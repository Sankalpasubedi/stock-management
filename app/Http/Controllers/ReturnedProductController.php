<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ReturnedProduct;
use App\Services\ReturnedService;
use App\Traits\Messages;
use App\Traits\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class ReturnedProductController extends Controller
{
    use SuccessMessage;


    public function paidReturn(ReturnedService $returnedService, $id)
    {
        try {
            DB::beginTransaction();
            $returnedService->creditAmountPaid($id);
            DB::commit();
            $this->getTaskSuccessMessage('Bill Payed');
            return redirect(route('return'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('return'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }


    }

    public function searchReturn(ReturnedService $returnedService, Request $request)
    {
        $returns = $returnedService->searchContent($request);
        return view('pages.returned', compact('returns'));
    }


    public function deleteReturned(ReturnedService $returnedService, $id)
    {
        try {
            DB::beginTransaction();
            $returnedService->deleteReturnedProducts($id);
            DB::commit();
            $this->getDestroySuccessMessage('Bill');
            return redirect(route('return'));

        } catch (CustomException $e) {
            DB::rollBack();
            $this->getErrorMessage($e->getMessage());
            return redirect(route('return'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('error'));
        }

    }

}
