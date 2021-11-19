<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    use DeleteModelTraits;

    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index()
    {
        $customer = DB::select("select * from customers");
        return view('admin.customer.index', compact('customer'));
    }

    public function create()
    {
        return view('admin.customer.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $name = $request->name;
            $address = $request->address;
            $phone_number = $request->phone_number;
            $date_of_birth = $request->date_of_birth;
            $email = $request->email;
            $password = Hash::make($request->password);

            DB::select("INSERT INTO customers (id, name, address, phone_number, date_of_birth, email, password) " .
                "VALUES (NULL, '" . $name . "', '" . $address . "', '" . $phone_number . "', '" . $date_of_birth . "', '" . $email . "', '" . $password . "')");
            DB::commit();
            return redirect()->route('customer.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('customer.create');
        }
    }

    public function edit($id)
    {
        $customer = $this->customer->find($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $dU = [
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'email' => $request->email,

            ];
            if (!empty($request->password)) {
                $dU = [
                    'password' => Hash::make($request->password),
                ];
                DB::select("UPDATE customers SET name = '".$dU['name']."', address = '".$dU['address']."', phone_number = '".$dU['phone_number']."'".
                    ", date_of_birth = '".$dU['date_of_birth']."', email = '".$dU['email']."', password = '".$dU['password']."' WHERE customers.id = ".$id."");
            }else{
                DB::select("UPDATE customers SET name = '".$dU['name']."', address = '".$dU['address']."', phone_number = '".$dU['phone_number']."'".
                    ", date_of_birth = '".$dU['date_of_birth']."', email = '".$dU['email']."' WHERE customers.id = ".$id."");
            }
//            $this->customer->find($id)->update($dU);

            DB::commit();
            return redirect()->route('customer.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('customer.index');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->customer);
    }
}
