<?php

namespace Modules\DomenyTv\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\DomenyTv\App\Http\Requests\AccountBalanceRequest;
use Modules\DomenyTv\App\Http\Resources\AccountBalanceResource;

class DomenyTvController extends Controller
{
    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    public function index()
    {
        return $this->show();
    }
    /**
     * Use the SoapWrapper
     */
    public function show()
    {
        $this->soapWrapper->add('domtv', function ($service) {
            $service
                ->wsdl(route('domenytv.index') . '/soap.wdl.xml')
                ->trace(true)
                ->classmap([
                    AccountBalanceRequest::class,
                    AccountBalanceResource::class,
//                    GetConversionAmount::class,
//                    GetConversionAmountResponse::class,
                ]);
        });



        $response = $this->soapWrapper->call('domtv.accountBalanceResult');

        dd($response ?? '+-+-+-','jalo');
        exit;
    }


//    public array $data = [];

//    /**
//     * Display a listing of the resource.
//     */
//    public function index(): JsonResponse
//    {
//        //
//
//        return response()->json($this->data);
//    }

//    public function index(Request $request, SoapWrapper $soapWrapper)
//    {
////        dd(route('api.domenytv') . '/soap.wdl.xml');
//        // Pobierz zawartość pliku WSDL (np. z URL)
//        $wsdl = file_get_contents(public_path() . '/modules/domenytv/soap.wdl.xml');
////dd('ooo',$wsdl);
//        // Dodaj dynamicznie pobrany plik WSDL do serwera SOAP
//        $soapWrapper->add('dtv', function ($service) use ($wsdl) {
//            $service->wsdl($wsdl);
//        });
////dd($soapWrapper);
//        // Wywołaj metodę SOAP
//        $response = $soapWrapper->call('dtv.accountBalance', [
//            'login' => 'ggg',
//            'password' => 'vvvv',
//        ]);
//
//        // Przetwarzanie odpowiedzi...
//
//
//        return response($response)->header('Content-Type', 'text/xml');
//    }


}
