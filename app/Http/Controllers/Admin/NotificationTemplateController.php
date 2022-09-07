<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Redirect;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $templates = Template::orderBy('id','desc')->get();
        return view('admin.notification.notificationTable', compact('templates'));
    }

    public function create()
    {
        abort_if(Gate::denies('notification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.notification.notificationCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required',
            'subject' => 'bail|required',
            'mail_content' => 'bail|required',
            'message_content' => 'bail|required',
        ]);
        $temp = new Template();
        $temp->title = $request->title;
        $temp->subject = $request->subject;
        $temp->mail_content = $request->mail_content;
        $temp->msg_content = $request->message_content;
        $temp->save();
        return redirect()->route('notification.index')->withStatus(__('Template Created Successfully.'));
    }

    
    public function show($id)
    {
        abort_if(Gate::denies('notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $template = Template::find($id);
        return response()->json(['msg' => 'Show Template', 'data' => $template, 'success' => true], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'bail|required',
            'mail_content' => 'bail|required',
            'message_content' => 'bail|required',
        ]);
        $temp = Template::find($id);
        $temp->subject = $request->subject;
        $temp->mail_content = $request->mail_content;
        $temp->msg_content = $request->message_content;
        $temp->save();
        return Redirect::back();
    }

    public function destroy(Template $template)
    {
        //
    }
}
