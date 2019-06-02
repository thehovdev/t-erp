<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Journal;
use App\Storage;
use App\Product;

class JournalController extends Controller
{

    public function incoming() {
        $journal = new Journal;
        $incoming_actions = $journal->where('receiver_id', Auth::id())->get();

        return view('journal.incoming')
            ->with('incoming_actions', $incoming_actions);
    }

    public function outgoing() {

        $journal = new Journal;
        $outgoing_actions = $journal->where('user_id', Auth::id())->get();

        return view('journal.outgoing')
            ->with('outgoing_actions', $outgoing_actions);

    }
}
