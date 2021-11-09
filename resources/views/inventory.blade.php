@extends('layouts.app')

@section('content')

<div class="row inventory">
  <div class="col-md-6">
    <div class="title">
      <h1>Inventaris</h1>
      <span>Embedded Cyber Physical System Laboratory</span>
    </div>
  </div>
  <div class="col-md-6">
    <form class="form" action="inventory/submit" method="POST">
      @csrf
      <h2>Input Inventory</h2>
      <div>
        <label for="type">Tipe</label>
        <select name="type" id="type">

          @foreach ($type as $i)
          <option value="{{ $i->id }}">{{ $i->name }}</option>
          @endforeach

        </select>
      </div>

      <div>
        <label for="locSpecific">Lokasi</label>
        <select name="locSpecific" id="locSpecific">

          @foreach ($locSpecifics as $i)
          <option value="{{ $i->id }}">{{ $i->name }}</option>
          @endforeach

        </select>
      </div>

      <div class="name">
        <label for="name">Nama Barang</label>
        <input type="text" name="name" id="name" autocomplete="off">

        <div class="selector">
          <span>List Barang Tersedia</span>
          <ul id="itemList">
            <li style="text-align: center;">-- Masukkan minimal 3 huruf --</li>
          </ul>
        </div>
      </div>

      {{-- <div>
        <label for="quantity">Jumlah</label>
        <div class="number">
          <input type="number" name="quantity" id="quantity">
          <button id="incQ"><i class="fa fa-plus" aria-hidden="true"></i></button>
          <button id="decQ"><i class="fa fa-minus" aria-hidden="true"></i></button>
        </div>
      </div> --}}

      <div class="item-id">
        <label for="itemId">ID Barang (hanya utk update barang)</label>
        <input type="number" name="itemId" id="itemId" @if (Session::has('itemId')) value="{{ Session::get('itemId') }}"
          style="background-color: yellow" @endif>
        <button id="itemIdSearch"><i class="fa fa-search" aria-hidden="true"></i></button>
        @if (Session::has('itemId')) <p style="color: yellow">Kode Barang Sebelumnya</p> @endif
      </div>

      <div>
        <input id="submit" type="submit" name="action" value="Submit">
        <input id="update" type="submit" name="action" value="Update" disabled>
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
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let selectorLi = document.querySelectorAll('.selector li');
    let name = document.querySelector('#name');
    let quantity = document.querySelector('#quantity');
    let itemId = document.querySelector('#itemId');
    let submit = document.querySelector('#submit');
    let update = document.querySelector('#update');
    let type = document.querySelector('#type');
    let locSpecific = document.querySelector('#locSpecific')
    let itemList = document.querySelector('#itemList');
    let itemIdSearch = document.querySelector('#itemIdSearch');

    update.disabled = true;

    itemIdSearch.onclick = function (e) { 
      e.preventDefault();

      let data = {
        'itemId': itemId.value,
      }

      fetch('inventory/searchId',{
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
        type.value = datas.type_id;
        locSpecific.value = datas.locSpecific_id;
        name.value = datas.name;

        submit.disabled = true;
        update.disabled = false;
      })
      .catch(function(error) {
        console.log(error);
      });
    }

    type.oninput = function(){
      name.value = "";
      itemList.textContent="";
      quantity.value = "";
    }

    name.oninput = function () {
      if (name.value.length >= 3) {
        let data = {
          'typeId': type.value,
          'name': name.value,
        }

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
            }
            itemList.appendChild(li);
          })
        })
        .catch(function(error) {
          console.log(error);
        });
      }
    }

    // document.querySelector('#incQ').onclick = function (e) {
    //   e.preventDefault();
    //   quantity.value = Number(quantity.value) + 1;
    // }
    // document.querySelector('#decQ').onclick = function (e) {
    //   e.preventDefault();
    //   quantity.value = Number(quantity.value) - 1;
    // }
  }
  window.onload = loadFunction;
</script>

@endsection