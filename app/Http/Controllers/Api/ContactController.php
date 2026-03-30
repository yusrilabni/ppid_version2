<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $contacts = Contact::orderBy('created_at', 'desc')->get();

            return response()->json($contacts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch contacts', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $contact = Contact::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message'],
                'read' => false, // Default value as per Prisma schema
            ]);

            return response()->json($contact, 201); // 201 Created
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create contact', 'message' => $e->getMessage()], 500);
        }
    }
}
