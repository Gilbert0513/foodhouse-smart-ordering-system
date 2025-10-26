@extends('layouts.app')

@section('title', 'Create New Order')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Create New Order</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="table_number" class="form-label">Table Number</label>
                    <input type="number" class="form-control" id="table_number" name="table_number" required min="1">
                </div>
            </div>

            <div class="mb-3">
                <h5>Order Items</h5>
                <div id="order-items">
                    <div class="row mb-2 item-row">
                        <div class="col-md-5">
                            <select class="form-select inventory-select" name="items[0][inventory_id]" required>
                                <option value="">Select Item</option>
                                @foreach($inventory as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->quantity }}">
                                    {{ $item->name }} - ₱{{ $item->price }} (Stock: {{ $item->quantity }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control quantity" name="items[0][quantity]" required min="1" placeholder="Qty">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control price" readonly placeholder="Price">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-item">×</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="add-item">Add Item</button>
            </div>

            <div class="mb-3">
                <strong>Total Amount: ₱<span id="total-amount">0.00</span></strong>
            </div>

            <button type="submit" class="btn btn-primary">Create Order</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let itemCount = 1;

document.getElementById('add-item').addEventListener('click', function() {
    const newRow = document.querySelector('.item-row').cloneNode(true);
    newRow.innerHTML = newRow.innerHTML.replace(/items\[0\]/g, `items[${itemCount}]`);
    newRow.querySelector('.inventory-select').selectedIndex = 0;
    newRow.querySelector('.quantity').value = '';
    newRow.querySelector('.price').value = '';
    document.getElementById('order-items').appendChild(newRow);
    itemCount++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        if (document.querySelectorAll('.item-row').length > 1) {
            e.target.closest('.item-row').remove();
            calculateTotal();
        }
    }
});

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('inventory-select') || e.target.classList.contains('quantity')) {
        const row = e.target.closest('.item-row');
        const select = row.querySelector('.inventory-select');
        const quantity = row.querySelector('.quantity');
        const price = row.querySelector('.price');
        
        if (select.value && quantity.value) {
            const itemPrice = select.options[select.selectedIndex].dataset.price;
            price.value = '₱' + (itemPrice * quantity.value).toFixed(2);
        }
        calculateTotal();
    }
});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.inventory-select');
        const quantity = row.querySelector('.quantity');
        
        if (select.value && quantity.value) {
            const itemPrice = select.options[select.selectedIndex].dataset.price;
            total += itemPrice * quantity.value;
        }
    });
    document.getElementById('total-amount').textContent = total.toFixed(2);
}
</script>
@endsection