@extends('layouts.app')

@section('content')

<div class="row inventory">
  <div class="col-md-6">
    <div class="title">
      <h1>Peminjaman</h1>
      <span>Embedded Cyber Physical System Laboratory</span>
    </div>
  </div>
  <div class="col-md-6">
    <form class="form" action="peminjaman/submit" method="POST">
      @csrf

      <h2>Identitas Peminjam</h2>
      <div>
        <label for="username">Nama</label>
        <input type="text" name="username" id="username">
      </div>
      <div>
        <label for="nrp">NRP</label>
        <input type="text" name="nrp" id="nrp">
      </div>


      <h2>Inventory</h2>
      <div>
        <label for="type">Tipe</label>
        <select name="type" id="type">

          @foreach ($type as $i)
          <option value="{{ $i->id }}">{{ $i->name }}</option>
          @endforeach

        </select>
      </div>

      <div class="name">
        <label for="name">Cari Barang</label>
        <input type="hidden" name="itemId" id="itemId">
        <input type="text" name="name" id="name" autocomplete="off">
        <div class="selector">
          <ul id="itemList">
            <li style="text-align: center;">-- Masukkan minimal 3 huruf --</li>
          </ul>
        </div>
      </div>

      <div>
        <label for="quantity">Jumlah</label>
        <div class="number">
          <input type="number" name="quantity" id="quantity">
          <button id="incQ"><i class="fa fa-plus" aria-hidden="true"></i></button>
          <button id="decQ"><i class="fa fa-minus" aria-hidden="true"></i></button>
        </div>
      </div>

      <div>
        <input id="pinjam" type="submit" value="Pinjam" disabled>
      </div>

    </form>

    @if (Session::has('notif'))
    <div class="notif">
      <p>{{ Session::get('notif') }}</p>
    </div>
    @endif

  </div>
</div>

<script>
  let loadFunction = function () {
    let selectorLi = document.querySelectorAll('.selector li');
    let username = document.querySelector('#username');
    let nrp = document.querySelector('#nrp');
    let name = document.querySelector('#name');
    let quantity = document.querySelector('#quantity');
    let itemId = document.querySelector('#itemId');
    let pinjam = document.querySelector('#pinjam');
    let type = document.querySelector('#type');
    let itemList = document.querySelector('#itemList');

    type.oninput = function(){
      name.value = "";
      itemList.textContent="";
      quantity.value = "";
    }

    name.oninput = function () {
      itemId.value = 0;
      pinjam.disabled = true;

      if (name.value.length >= 3) {
        let data = {
          'typeId': type.value,
          'name': name.value,
        }
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('inventory/search', {
          method: 'POST',
          credentials: "same-origin",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token,
          },
          body: JSON.stringify(data),
        })
        .then((resp)=>resp.json())
        .then(function(datas){
          itemList.textContent="";
          return datas.map(function(data){
            let li = document.createElement('li');
            li.innerHTML = data.name;
            li.onclick = function(){
              name.value = li.innerHTML;
              itemId.value = data.id;
              //quantity.value = data.quantity;
              pinjam.disabled = false;
              //update.disabled = false;
            }
            itemList.appendChild(li);
          })
        })
        .catch(function(error) {
          console.log(error);
        });
      }
    }

    document.querySelector('#incQ').onclick = function (e) {
      e.preventDefault();
      quantity.value = Number(quantity.value) + 1;
    }
    document.querySelector('#decQ').onclick = function (e) {
      e.preventDefault();
      quantity.value = Number(quantity.value) - 1;
    }
  }
  window.onload = loadFunction;
</script>

@endsection