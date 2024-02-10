<?php

namespace App\Http\Controllers\Admin;


use App\Exports\UsersExport;
use App\Grids\UsersGrid;
use App\Models\ResidentialCategory;
use App\Models\User;
use App\Models\UserProfile;
use App\Notifications\Admin\User\UserVerifiedNotification;
use DataTables;
use Grids;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Woo\GridView\DataProviders\EloquentDataProvider;

class UserController extends AdminController
{
    protected $users;
    protected $digitalAddress;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Last One Year Digital Address Report";
        $subtitle = "Monthly";

        $this->users = User::select('*')->orderBy('created_at', 'desc');

        $this->applyFilters($request);

        if ($request->download) {
            return Excel::download(new UsersExport($request), 'digital_addresses.xlsx');
        }
        $users = $this->users->paginate();
        $dataProvider =  new EloquentDataProvider($this->users);
        $datas = User::select(\DB::raw('COUNT(id) as count'));

        if ($request->dwm == 'Daily') {

            $subtitle = "Daily";
            $datas = $datas->addSelect(\DB::raw('DATE_FORMAT(created_at, "%D %b") as month'));
        } else if ($request->dwm == 'Weekly') {
            $subtitle = "Weekly";
            $datas = $datas->addSelect(\DB::raw('DATE_FORMAT(created_at, "%U") as month'));
        } else if ($request->dwm == 'Monthly') {
            $subtitle = "Monthly";
            $datas = $datas->addSelect(\DB::raw('DATE_FORMAT(created_at, "%b") as month'));
        } else {
            $datas = $datas->addSelect(\DB::raw('DATE_FORMAT(created_at, "%b") as month'));
        }
        /* if($request->year)
        {
            $datas->whereYear('users.created_at', $request->year);
        }else
        {
            $datas = $datas->where('users.created_at', '>=', Carbon::now()->subYear());
        }*/
        //dd($datas->groupBy('month')->get()->pluck('count', 'month')->toArray());
        //$datas = $datas->groupBy('month')->orderBy('created_at', 'asc')->get()->pluck('count', 'month')->toArray();
        $datas = $datas->groupBy('month')->get()->pluck('count', 'month')->toArray();
        return view('admin.user.grid', compact('users', 'datas', 'dataProvider', 'title', 'subtitle'));
    }

    public function applyFilters($request)
    {

        !$request->name || $this->users->orWhere('users.name', 'like', "%{$request->name}%");

        !$request->mobile_number || $this->users->orWhere('users.mobile_number', 'like', "%{$request->mobile_number}%");

        !$request->email || $this->users->orWhere('users.email', 'like', "%{$request->email}%");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = User::findOrFail($id);

        $this->digitalAddress = $user->digitalAddresses()->with('user', 'address', 'addressArea', 'addressChiefdom', 'addressSection')->orderBy('created_at', 'desc');
        $this->applyFiltersDigitalAddress($request);
        $digitalAddress = $this->digitalAddress->paginate();

        //dd(DigitalAddress::query()->where('user_id',$id));
        /* return view('admin.user.show',[
                'dataProvider' => new EloquentDataProvider(DigitalAddress::query()->with('address','address.addressArea','address.addressChiefdom','address.addressSection','addressArea','addressChiefdom','addressSection')->where('user_id',$id)),
                'user' =>$user
            ] );*/
        return view('admin.user.show', [
            'digitalAddresses' => $digitalAddress,
            'user' => $user
        ]);
    }

    public function applyFiltersDigitalAddress($request)
    {
        !$request->area || $this->digitalAddress->whereHas('addressArea', function ($query) use ($request) {
            return $query->where('name', 'like', "%{$request->area}%");
        });

        !$request->chiefdom || $this->digitalAddress->whereHas('addressChiefdom', function ($query) use ($request) {
            return $query->where('name', 'like', "%{$request->chiefdom}%");
        });

        !$request->section || $this->digitalAddress->whereHas('addressSection', function ($query) use ($request) {
            return $query->where('name', 'like', "%{$request->section}%");
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->guard()->user()->hasRole('admin')) {
            $user = User::findOrFail($id);

            return view('admin.user.edit', compact('user'));
        }
        abort(403, 'User does not have the right roles.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->guard()->user()->hasRole('admin')) {
            $user = User::findOrFail($id);

            $rules = [
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required'],
                'is_active' => ['nullable']
            ];


            $data = $request->only([
                'name',
                'email',
                'is_active',
                'is_edsa_agent',
                'is_dstv_agent'
            ]);

            $user->update($data);

            return redirect()->route('admin.user.show',  $id)->with($this->setMessage('User successfully updated.', self::MESSAGE_SUCCESS));;
        }
        abort(403, 'User does not have the right roles.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
