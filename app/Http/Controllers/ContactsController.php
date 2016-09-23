<?php

namespace App\Http\Controllers;

use App\Contact;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class ContactsController extends Controller
{
    public function index(){

        $user = \Auth::user();

        $contacts = Contact::where('user_id',$user->id)->get();

    	return view('contacts.index', compact('contacts', 'user'));
    }

    public function show(Contact $contact){

        $user = \Auth::user();

        if($contact->user_id == $user->id){
        	return view('contacts.show', compact('contact', 'user'));
        }
        else{
            return back();
        }
    }

    public function store(){
    	$contact = new Contact(request()->all());
        $contact->user_id = \Auth::id();
        if(count(request()->custom) > 0){
            $contact->custom1 = request()->custom[0]; 
        }
        else{
            $contact->custom1 = ''; 
        }
        if(count(request()->custom) > 1){
            $contact->custom2 = request()->custom[1]; }
        else{ 
            $contact->custom2 = ''; 
        }
        if(count(request()->custom) > 2){
            $contact->custom3 = request()->custom[2]; 
        }
        else{ 
            $contact->custom3 = ''; 
        }
        if(count(request()->custom) > 3){
            $contact->custom4 = request()->custom[3]; 
        }
        else{ 
            $contact->custom4 = ''; 
        }
        if(count(request()->custom) > 4){
            $contact->custom5 = request()->custom[4]; 
        }
        else{ 
            $contact->custom5 = ''; 
        }
        $acpostdata = array(
            'email'                    => $contact->email,
            'first_name'               => $contact->fname,
            'last_name'                => $contact->lname,
            'phone'                    => $contact->phone,
            'custom1'                  => $contact->custom1,
            'custom2'                  => $contact->custom2,
            'custom3'                  => $contact->custom3,
            'custom4'                  => $contact->custom4,
            'custom5'                  => $contact->custom5,
        );
    	$contact = $contact->save();

        $ac = app('ActiveCampaign');
        $ac->api('contact/add', $acpostdata);
        return back();
    }


    public function update(Contact $contact){
        $oldemail = $contact->email;
        if(count(request()->custom) > 0){
            $contact->custom1 = request()->custom[0]; 
        }
        else{ 
            $contact->custom1 = ''; 
        }
        if(count(request()->custom) > 1){
            $contact->custom2 = request()->custom[1]; 
        }
        else{ 
            $contact->custom2 = ''; 
        }
        if(count(request()->custom) > 2){
            $contact->custom3 = request()->custom[2]; 
        }
        else{ 
            $contact->custom3 = ''; 
        }
        if(count(request()->custom) > 3){
            $contact->custom4 = request()->custom[3]; 
        }
        else{ 
            $contact->custom4 = '';
        }
        if(count(request()->custom) > 4){
            $contact->custom5 = request()->custom[4]; 
        }
        else{ 
            $contact->custom5 = ''; 
        }
        $contact->save();

    	$contact->update(request()->all());
        
        $acpostdata = array(
            'email'                    => $contact->email,
            'first_name'               => $contact->fname,
            'last_name'                => $contact->lname,
            'phone'                    => $contact->phone,
            'field[1,0]'               => $contact->custom1,
            'field[2,0]'               => $contact->custom2,
            'field[3,0]'               => $contact->custom3,
            'field[4,0]'               => $contact->custom4,
            'field[5,0]'               => $contact->custom5,
        );

        $ac = app('ActiveCampaign');
        
        if($oldemail == $contact->email){
             $ac->api('contact/sync', $acpostdata);  
        }
        else{
            $con = $ac->api('contact/view?email='.$oldemail);
            $acpostdata['id'] = $con->id;
            $acpostdata['p['.$con->listid.']'] = $con->listid;
            $ac->api('contact/edit', $acpostdata);
        }   
    	
    	return back();
    }

    public function delete(Contact $contact){
        $ac = app('ActiveCampaign');
        $con = $ac->api('contact/view?email='.$contact->email);
        if($con){
             $ac->api('contact/delete?id='.$con->id);
        }   
        $contact->delete();

        return redirect(url('contacts'));
    }

    public function search(){
        $user = \Auth::user();
        $searchTerms = request()->searchterms;
        $searches = $searchTerms;
        $searchTerms = explode(' ', $searchTerms);
        $query = DB::table('contacts')->where('user_id',$user->id);

        foreach($searchTerms as $searchTerm):

            $query->where(function($q) use ($searchTerm){
                $q->where('lname', 'like', '%'.$searchTerm.'%')
                  ->orWhere('email', 'like', '%'.$searchTerm.'%')
                  ->orWhere('phone', 'like', '%'.$searchTerm.'%');
            });

        endforeach;
        
    
        $contacts = $query->get();


        return view('contacts.index', compact('contacts', 'user', 'searches'));
    }
}