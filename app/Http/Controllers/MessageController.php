<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Store a newly created message in storage.
     */
    public function store(MessageRequest $request)
    {
        Message::create($request->validated());

        return back()->with('success', 'Terima kasih! Pesan Anda berhasil dikirim.');
    }
}