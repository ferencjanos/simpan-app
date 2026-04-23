<?php

namespace App\Notifications;

use App\Models\Disposisi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DisposisiBaru extends Notification
{
    use Queueable;

    protected $disposisi;

    public function __construct(Disposisi $disposisi)
    {
        $this->disposisi = $disposisi;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'disposisi_id'  => $this->disposisi->id,
            'surat_masuk'   => $this->disposisi->suratMasuk->nomor_surat,
            'perihal'       => $this->disposisi->suratMasuk->perihal,
            'dari'          => $this->disposisi->dariUser->name,
            'instruksi'     => $this->disposisi->instruksi,
            'message'       => 'Anda mendapat disposisi baru dari ' . $this->disposisi->dariUser->name,
        ];
    }
}