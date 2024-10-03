@props(['min' => 0, 'max' => null, 'value' => 0])

<div>
    <input type="text" name="{{ $attributes->get('name') }}" id="{{ $attributes->get('id') }}"
        class="{{ $attributes->get('class') }}" placeholder="0" onkeydown="return keyDown(event)" required>
    <small id="error-{{ $attributes->get('id') }}" class="text-danger" style="display:none;"></small>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // get id form input
            const id = @json($attributes->get('id'));
            const min = @json($min);
            const max = @json($max);

            // get value from input
            const value = @json($value);
            $(`#${id}`).val(fNumber(value));

            const input = document.getElementById(id);

            input.closest('form').addEventListener('submit', function(e) {
                // Mengambil elemen form terdekat dari input
                var form = e.target;
                var errorElement = input.nextElementSibling;
                var newValue = parseFloat(input.value.replace(/[^,\d]/g, ''));
                console.log(errorElement);

                // Validasi input
                if (min && newValue < min) {
                    e.preventDefault(); // Mencegah form dari pengiriman
                    // Tampilkan pesan error
                    errorElement.textContent = `Input tidak boleh kurang dari ${min}`;
                    // Tampilkan elemen error
                    errorElement.style.display = 'block';
                }
                if (max && newValue > max) {
                    e.preventDefault(); // Mencegah form dari pengiriman
                    // Tampilkan pesan error
                    errorElement.textContent = `Input tidak boleh lebih dari ${max}`;
                    // Tampilkan elemen error
                    errorElement.style.display = 'block';
                }
                if (min && newValue < min && max && newValue > max) {
                    errorElement.style.display = 'none'; // Sembunyikan elemen error jika valid
                }
            });

            // gunakan fungsi fNumber() untuk mengubah angka yang di ketik menjadi format angka
            input.addEventListener('keyup', function(e) {
                input.value = fNumber(this.value);
            });

            input.addEventListener('focus', function(e) {
                // select all text
                input.select();
            })
        });
    </script>
@endpush
