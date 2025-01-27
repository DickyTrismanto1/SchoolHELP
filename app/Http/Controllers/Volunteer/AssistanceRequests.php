<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\Data;
use App\Models\mRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class AssistanceRequests extends Controller
{
  protected $breadcrumb;

  public function __construct() {
    $breadcrumb = [
      [
        'name' => 'Dashboard',
        'route' => route('dashboard_volunteer')
      ],
      [
        'name' => 'Assistance Requests',
        'route' => route('assistance_request')
      ],
    ];
    $this->breadcrumb = $breadcrumb;
  }

  public function index() {
    $list_requests = mRequest::where('req_status', 'new')->get(['id_request','id_school','req_description','created_at']);
    $data = array_merge(Data::data($this->breadcrumb), [
      'list_requests' => $list_requests,
    ]);
    return view('volunteer/assistanceRequests/list', $data);
  }

//  public function create_offer($id_request) {
//		isi
//  }

//  public function store_offer(Request $request, $id_request) {
//		isi
//  }

  public function detail_request($id_request) {
    $id_request = Crypt::decrypt($id_request);
    $data = [
      'detail' => mRequest::find($id_request),
    ];
    return view('volunteer/assistanceRequests/detailRequest', $data);
  }

  public function list_offers() {
    // breadcrumb
    $breadcrumb = [
      [
        'name' => 'Dashboard',
        'route' => route('dashboard_volunteer')
      ],
      [
        'name' => 'Offers',
        'route' => route('list_offers')
      ],
    ];

    // data
    $user = Auth::user();
    $list_offers = Offer::where('id_user', $user->id_user)->get();
    $data = array_merge(Data::data($breadcrumb), [
      'list_offers' => $list_offers,
    ]);
    return view('volunteer/assistanceRequests/listOffer', $data);

  }

//  public function delete_offer(Request $request, $id_offer) {
//		isi
//  }
}
