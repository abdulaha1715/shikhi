@if (Session('error'))
    <div id="status_message" class="alert-danger alert">
        <p>{{ Session('error') }}</p>
    </div>
@endif

@if (Session('success'))
    <div id="status_message" class="alert-success alert">
        <p>{{ Session('success') }}</p>
    </div>
@endif

@section('message-script')
    <script>
        jQuery(document).ready(function($) {
            setTimeout(() => {
                $('#status_message').addClass("close");
            }, 5000);
        });
    </script>
@endsection

