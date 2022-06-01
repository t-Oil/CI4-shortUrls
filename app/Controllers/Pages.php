<?php

namespace App\Controllers;

use App\Models\Urls;
use chillerlan\QRCode\QRCode;


class Pages extends BaseController
{
    public function index()
    {
        $data['tittle'] =  'Short.URL';

        $data['listUrl'] = (new Urls)->orderBy('count', 'desc')->findAll('15','0');

        return view('pages/home', $data);
    }

    public function genUrl()
    {
        $input = $this->validate([
            'url' => 'required|min_length[3]|max_length[10000]|valid_url'
        ]);

        if (!$input) {
            session()->setFlashdata('err', $this->validator->listErrors());
        } else {

            $fullUrl = $this->request->getVar('url');

            // Loading Helper text
            helper('text');

            $slug = random_string('alnum', 8);
            $qrImg = (new QRCode)->render(base_url($slug));

            $url = new Urls;
            $url->save([
                'slug' => $slug,
                'full_url' => $fullUrl,
                'qr' =>$qrImg
            ]);

            $res = [
                'slug' => $slug,
                'fullUrl' => $fullUrl,
                'img' => $qrImg
            ];

            session()->setFlashdata('url', $res);
        }

        return redirect()->to('/');
    }

    public function redirect()
    {
        $getSlug = $this->request->getPath();
        
        $model = new Urls();
        $data = $model->where('slug', $getSlug)->first();

        if ($data === null) {
            return redirect()->to('/');
        }

        $params = [
            'last_visit_at' => date('Y-m-d H:i:s'),
            'count' => $data['count'] + 1
        ];
        
        $model->update($data['id'], $params);

        return redirect()->to($data['full_url']);
    }
}
