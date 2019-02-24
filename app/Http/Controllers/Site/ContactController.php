<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/28/2017
 * Time: 10:07 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Contact;
use App\Entity\Notification;
use App\Entity\Input;
use App\Entity\MailConfig;
use App\Entity\Post;
use App\Mail\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class ContactController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }

    public function index() {

         return view('site.default.contact');
    }

    public function submit(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return response([
				'status' => 500,
				'message' => 'Lỗi điền form văn bản.',
			])->header('Content-Type', 'text/plain');
		 
			// return redirect(route('contact_home'))
                // ->withErrors($validation)
                // ->withInput();
        }
		 
        //success
        $contact = new Contact();
        $contact->insert([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
			'images' => $request->has('images') ? implode('-', $request->input('images')) : '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $orderDb = new Notification();
           $orderDb->insert([
               'title' => 'Liên hệ',
               'content' => 'Bạn vừa có liên hệ mới',
               'status' => '0',
               'url' => asset('/admin/contact'),
               'created_at' => new \DateTime(),
               'updated_at' => new \DateTime()
           ]);

        $success = 1;
        $this->sendMainContact($request);
		
		if ($request->has('is_upload_image') == 1) {
			return redirect('/trang/cam-on-mua-thuoc-theo-toa');
		}
		
		return response([
             'status' => 200,
             'message' => 'Cảm ơn bạn đã liên hệ cho chúng tôi, chúng tôi sẽ phản hồi sớm nhất.',
         ])->header('Content-Type', 'text/plain');

    }


    private function sendMainContact($request)  {

        $subject =  'Có liên hệ mới từ website';
        $content = '<p>Khách hàng: '. $request->input('name'). ' </p>

        <p>SĐT : ' . $request->input('phone') . '</p> 

        <p>Email : '. $request->input('email') . '</p>

        <p>Nội dung liên hệ : ' . $request->input('message') . '</p>';

        MailConfig::sendMail('', $subject, $content);
    }
}
