<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function edit(Request $request, Contact $contact)
    {
        $this->authorize('update-contact', $contact);

        return view('contacts.edit', ['contact' => $contact]);
    }
}
