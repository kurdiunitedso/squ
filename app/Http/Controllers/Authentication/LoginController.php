<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WhatsappHistory;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $user = User::where('email', $request->email)->first();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString()
            ]);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'title' => 'Invalid credentials',
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public
    function webhookwa(Request $request)
    {
        if ($request->hub_token == 'Tabibfind')
            return $request->hub_challenge;

        else
            return $request->hub_challenge;
    }

    public
    function webhookwa2(Request $request)
    {
        $dd = $request->all();
        $d = $dd["entry"][0]["changes"][0];

        if ($d['value'] && count($d['value']) > 0) {
            if (is_array($d['value']['messages'])) {
                for ($i = 0; $i < count($d['value']['messages']); $i++) {
                    $c = $d['value']['messages'][$i];

                    $w = new WhatsappHistory();

                    if ($c['type'] == 'interactive') {

                        $w->body = $c['interactive']['list_reply']['title'];
                    } else if ($c['type'] != 'text') {
                        $url = $this->getwhatsappMediaURL($c[$c['type']]['id'], $request->type);
                        $w->body = $url;
                    } else
                        $w->body = $c['text']['body'];
                    //$w->body = json_encode($dd);
                    $w->fromMe = 0;
                    $w->id = $c['id'];
                    $w->isForwarded = 0;
                    $w->time = strtotime(date('Y-m-d H:i:s'));
                    $w->chatId = $c['from'];
                    $w->type = $c['type'] == "text" ? 'chat' : $c['type'];

                    $w->senderName = $d['value']['contacts'][0]['profile']['name'];
                    $w->quotedMsgId = $c['id'];;
                    $w->chatName = $c['from'];
                    $w->instance_name = $request->type;

                    $w->save();


                }
            }
            return $request->hub_challenge;
        }
        //return $request->hub_challenge;
        return response($request->hub_challenge, 200);
    }

    function getwhatsappMediaURL($id, $instanceId = "Tabibfind")
    {

        if ($instanceId == "Tabibfind") {
            $version = env('Tabibfind_version', 0);
            $phoneID = env('Tabibfind_phoneID', 0);
            $tokenWHGraph = env('Tabibfind_token', 0);
        }
        $url = "https://graph.facebook.com/$version/$id";
        $client = new Client(['headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer $tokenWHGraph"]]);
        $response = $client->get(
            $url
        );


        $d = json_decode($response->getBody(), true);
        $url = $d["url"];
        $ext = substr($d["mime_type"], strpos($d["mime_type"], "/") + 1);
        // return $url;
        if ($url) {
            $path = public_path('attachments'); // upload directory

            $message = '';
            $client = new Client(['headers' => ['Authorization' => "Bearer $tokenWHGraph"]]);
            $filename = time() . Str::random(25) . '.' . $ext;
            $dest = $path . DIRECTORY_SEPARATOR . $filename;
            $resource = fopen($dest, 'w');

            // $stream = \GuzzleHttp\Psr7\Utils::streamFor($resource);
            //$client->request('GET', $url, ['save_to' => $stream]);

            $client->request('GET', $url, ['sink' => $resource]);
            // if($request->hasFile('image'))
            //{


            //Storage::disk('excel')->put($filename, file_get_contents($url));


            $link = "https://elite.developon.co/attachments/" . $filename;

            return $link;
        }
        return $url;


    }
    public
    function testwhatsapp(Request $request)
    {
        try {
            $message = "";
            if (request()->token)
                $token = request()->token;
            if (request()->instanceId)
                $instanceId = request()->instanceId;

            //return  $this->getoptions('Clinic','972599528821@c.us');

            // $options = $this->getOptions('Clinic', '972599528821@c.us');
            return $this->sendWhatsapp($request->mobile, $request->body, $request->type, $token, $instanceId, 0, $request->type2, $request->link);


        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
