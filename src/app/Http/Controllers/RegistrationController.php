<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\Contracts\LinkServiceInterface;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    protected LinkServiceInterface $links;

    public function __construct(LinkServiceInterface $links)
    {
        $this->links = $links;
    }

    public function show()
    {
        return view('welcome');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::firstOrCreate(
            ['phone' => $data['phonenumber']],
            ['name' => $data['username'], 'email' => $data['phonenumber'].'@placeholder.local', 'password' => bcrypt(Str::random(16))]
        );

        $link = $this->links->createForUser($user);

        return redirect()->route('link.show', ['token' => $link->token]);
    }
}
