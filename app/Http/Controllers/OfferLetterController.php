<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferLetter;
use App\Models\Applicant;
use App\Models\Job;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OfferLetterMail;


class OfferLetterController extends Controller
{
    public function create($applicantId)
    {
        $applicant = Applicant::findOrFail($applicantId);
        $jobs = Job::all();

        return view('offer_letters.create', compact('applicant', 'jobs'));
    }

public function store(Request $request)
{
    $request->validate([
        'applicant_id'   => 'required|exists:applicants,id',
        'job_id'         => 'required|exists:jobs,id',
        'letter_number'  => 'required|unique:offer_letters,letter_number',
        'offer_date'     => 'required|date',
        'join_date'      => 'nullable|date',
        'basic_salary'   => 'required|numeric',
         'responsibility_allowance' => 'nullable|numeric',
        'contract_duration' => 'nullable|string' // hanya dipakai kalau employee_type = contract
    ]);

    // Hitung allowance otomatis 30% dari basic
    $allowance = $request->basic_salary * 0.3;

    // Kalau responsibility kosong → jadikan 0
    $responsibility = $request->responsibility_allowance ?? 0;

    $total = $request->basic_salary + $allowance + $responsibility;

    $offer = OfferLetter::create([
        'applicant_id'      => $request->applicant_id,
        'job_id'            => $request->job_id,
        'letter_number'     => $request->letter_number,
        'offer_date'        => $request->offer_date,
        'join_date'         => $request->join_date,
        'basic_salary'      => $request->basic_salary,
        'allowance'         => $allowance, // otomatis
        'total_salary'      => $total,
        'contract_duration' => $request->contract_duration, // kalau kontrak
        'notes'             => $request->notes,
         'responsibility_allowance' =>  $responsibility
    ]);

    return redirect()->route('offer_letters.show', $offer->id)
        ->with('success', 'Offering Letter berhasil dibuat.');
}


    public function show($id)
    {
        $offer = OfferLetter::with(['applicant', 'job'])->findOrFail($id);
        return view('offer_letters.show', compact('offer'));
    }

    public function downloadPdf($id)
    {
        $offer = OfferLetter::with(['applicant', 'job'])->findOrFail($id);

        $pdf = Pdf::loadView('offer_letters.pdf', compact('offer'));
        return $pdf->stream("Offering-Letter-{$offer->letter_number}.pdf");
    }

    public function edit($id)
    {
        $offer = OfferLetter::findOrFail($id);
        $applicant = Applicant::findOrFail($offer->applicant_id);
        $jobs = Job::all();

        return view('offer_letters.edit', compact('offer', 'applicant', 'jobs'));
    }

    public function update(Request $request, $id)
    {
        $offer = OfferLetter::findOrFail($id);

        $request->validate([
            'job_id'         => 'required|exists:jobs,id',
            'letter_number'  => 'required|unique:offer_letters,letter_number,' . $offer->id,
            'offer_date'     => 'required|date',
            'join_date'      => 'nullable|date',
            'basic_salary'   => 'required|numeric',
            'responsibility_allowance' => 'nullable|numeric',
            'contract_duration' => 'nullable|string' // hanya dipakai kalau employee_type = contract
        ]);

        // Hitung allowance otomatis 30% dari basic
        $allowance = $request->basic_salary * 0.3;

        // Kalau responsibility kosong → jadikan 0
        $responsibility = $request->responsibility_allowance ?? 0;

        $total = $request->basic_salary + $allowance + $responsibility;

        $offer->update([
            'job_id'            => $request->job_id,
            'letter_number'     => $request->letter_number,
            'offer_date'        => $request->offer_date,
            'join_date'         => $request->join_date,
            'basic_salary'      => $request->basic_salary,
            'allowance'         => $allowance, // otomatis
            'total_salary'      => $total,
            'contract_duration' => $request->contract_duration, // kalau kontrak
            'notes'             => $request->notes,
             'responsibility_allowance' =>  $responsibility
        ]);

        return redirect()->route('offer_letters.show', $offer->id)
            ->with('success', 'Offering Letter berhasil diperbarui.');
    }

    public function sendEmail($id)
    {
        $offer = OfferLetter::with(['applicant', 'job'])->findOrFail($id);

        $pdf = Pdf::loadView('offer_letters.pdf', compact('offer'));

        Mail::to($offer->applicant->email)->send(new OfferLetterMail($offer, $pdf->output()));
        Log::info("Offer letter sent to {$offer->applicant->email} for offer ID: {$offer->id}");

       
        if(request()->ajax()){
            return response()->json(['message' => 'Offer letter sent to ' . $offer->applicant->email]);
        }

        return back()->with('success', 'Offer letter sent to ' . $offer->applicant->email);
    }


    // email : recruitment@isolutions.co.id
    // pw : R3cru1tm3nt#2025
}

