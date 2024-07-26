<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use App\Http\Requests\Admin\ContactUpdateRequest;
use App\Traits\DatatableTrait;

class ContactController extends Controller
{
    use DatatableTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Contact::query()        // this is working because it has query() and other does not work because those doesnot have query()
            ->select(['id', 'name', 'email', 'phone'])
            ->latest();
    
            $config = [
                'additionalColumns' => [
                ],
                'disabledButtons' => ['edit'],
                'model' => 'Contact',
                'rawColumns' => [],
                'sortable' => false,
                'routeClass' => null,
            ];
    
            return $this->getDataTable($request, $query, $config)->make(true);
        }
        return view('admin.contact.index', [
            'columns' => ['name', 'email', 'phone'],
        ]);
    }

    public function create(): View
    {
        return view('admin.contact.create');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        Contact::create($request->safe()->all());

        return redirect()->route('admin.contacts.index')->with('success', 'Contact Created Successfully!');
    }

    public function show(Contact $contact): View
    {
        return view('admin.contact.show', compact('contact'));
    }

    public function edit(Contact $contact): View
    {
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(ContactUpdateRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()->route('admin.contacts.index')->with('success', 'Contact Updated Successfully!');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('error', 'Contact Deleted Successfully!');
    }

    public function showNotification(Contact $contact): View
    {
        return view('admin.contact.show_notification', compact('contact'));
    }
}
