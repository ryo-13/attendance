<template>
    <div>
        <h1 class="text-center">ビデオチャット</h1>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="card" style="padding:15px;">
                    <div v-for="(name,userId) in others">
                        <a href="#" @click.prevent="startVideoChat(userId)">{{ name }}さんと通話を開始する</a>
                    </div>
                    <span v-if="isCalled" v-on:click="endOfCall" class="text-center"><button class="btn btn-danger">終了</button></span>
                    <transition name="fade">
                        <div v-if="err" class="alert alert-danger text-center" role="alert">
                            {{ err }}
                        </div>
                    </transition>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-5">
                <div class="text-center">自分の映像</div>
                <video ref="video-here" autoplay></video>
            </div>
            <div class="col-2 text-center">
                ⇔<br>
                ビデオチャット
            </div>
            <div class="col-5">
                <div class="text-center">相手の映像</div>
                <video ref="video-there" autoplay></video>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: '',
            others: '',
            pusherKey: '',
            pusherCluster: '',

            channel: null,
            stream: null,
            peers: {},

            isCalled: false,
            callUserId: null,

            err: '',
        }
    },
    methods: {
        endOfCall() {
            this.peers[this.callUserId].destroy();
        },
        startVideoChat(userId) {
            this.getPeer(userId, true);
        },
        getPeer(userId, initiator) {
            if (this.peers[userId] === undefined) {
                let peer = new Peer({
                    initiator,
                    stream: this.stream,
                    trickle: false
                });

                if (!this.channel.members.get(userId)) {
                    this.err = 'ユーザーが接続されていません';
                    setTimeout(() => {
                        this.err = '';
                    }, 1000);
                    return;
                }

                peer.on('signal', (data) => {
                    this.channel.trigger('client-signal-' + userId, {
                        userId: this.user.id,
                        data: data
                    });
                })
                .on('stream', (stream) => {
                    const videoThere = this.$refs['video-there'];
                    videoThere.srcObject = stream;
                    this.isCalled = true;
                    this.callUserId = userId;
                })
                .on('close', () => {
                    const peer = this.peers[userId];
                    if (peer !== undefined) {
                        peer.destroy();
                    }
                    delete this.peers[userId];
                    const videoThere = this.$refs['video-there'];
                    videoThere.srcObject = null;
                    this.isCalled = false;
                })
                .on('error', () => {
                    const peer = this.peers[userId];
                    if (peer !== undefined) {
                        peer.destroy();
                    }
                    delete this.peers[userId];
                    const videoThere = this.$refs['video-there'];
                    videoThere.srcObject = null;
                    this.isCalled = false;
                });
                this.peers[userId] = peer;
            }
            return this.peers[userId];
        },
    },
    mounted() {
        axios.get('/api/video-chat')
        .then(res => {
            this.user = res.data.user;
            this.others = res.data.others;
            this.pusherKey = res.data.pusherKey;
            this.pusherCluster = res.data.pusherCluster;
        })
    },
    watch: {
        pusherCluster: function() {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then((stream) => {
                const videoHere = this.$refs['video-here'];
                videoHere.srcObject = stream;
                this.stream = stream;

                const pusher = new Pusher(this.pusherKey, {
                    authEndpoint: '/api/auth/video-chat',
                    cluster: this.pusherCluster,
                    auth: {
                        headers: {
                            'Authorization': 'Bearer ' + this.user.api_token,
                        }
                    }
                });

                this.channel = pusher.subscribe('presence-video-chat');
                this.channel.bind('client-signal-' + this.user.id, (signal) => {
                    const userId = signal.userId;
                    const peer = this.getPeer(userId, false);
                    peer.signal(signal.data);
                });
            });
        }
    }
}
</script>

<style>
    video {
        width: 100%;
        height: 100%;
    }

    .fade-enter-active {
        animation: bounce-in .5s;
    }

    .fade-leave-active {
        animation: bounce-in .5s reverse;
    }

    @keyframes bounce-in {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
