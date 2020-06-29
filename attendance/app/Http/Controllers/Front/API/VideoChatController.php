<?php

namespace App\Http\Controllers\Front\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\Pusher;

class VideoChatController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getDataForPusher(Request $request)
    {
        $user = $request->user();
        $others = User::where('id', '!=', $user->id)->pluck('name', 'id');
        $response = collect([
            'user' => $user,
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
            'others' => $others,
        ]);
        return $response;
    }

    /**
     * Pusherの認証
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function auth(Request $request)
    {
        $user = $request->user();
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;

        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true
            ]
        );

        return response(
            $pusher->presence_auth($channelName, $socketId, $user->id)
        );

    }
}
