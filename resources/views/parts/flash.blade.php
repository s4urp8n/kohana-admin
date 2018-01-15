@if(request()->session()->has('status'))
    <script>
        alert("{{ request()->session()->get('status') }}")
    </script>
@endif