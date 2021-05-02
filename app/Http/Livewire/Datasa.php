<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Datamu;

class Datasa extends Component
{
    public $datamus, $nama, $tanggal, $keterangan, $datamu_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->datamus = Datamu::all();
        return view('livewire.datasa');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    public function resetCreateForm(){
        $this->nama = '';
        $this->tanggal = '';
        $this->keterangan = '';
    }
    
    public function store()
    {
        $this->validate([
            'nama' => 'required|string',
            'tanggal' => 'required|string',
            'keterangan' => 'required|string',
        ]);
    
        Datamu::updateOrCreate(['id' => $this->datamu_id],[
            'nama' => $this->nama,
            'tanggal' => $this->tanggal,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('message', $this->datamu_id ? 'datamu updated.' : 'datamu created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $datamu = Datamu::findOrFail($id);
        $this->id = $id;
        $this->nama = $datamu->nama;
        $this->tanggal = $datamu->tanggal;
        $this->keterangan = $datamu->keterangan;
    
        $this->openModalPopover();
    }
    
    public function delete($id)
    {
        Datamu::find($id)->delete();
        session()->flash('message', 'Datamu deleted.');
    }
}

