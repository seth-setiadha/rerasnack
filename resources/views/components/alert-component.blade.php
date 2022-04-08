<div>
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="liveAlertPlaceholder">    
    </div>

    <script type="text/javascript">
        var alertPlaceholder = document.getElementById('liveAlertPlaceholder');
        function functionAlertPlaceholder(message, type, divID) {
            var wrapper = document.getElementById(divID);
            if(document.getElementById(divID)) {                 
            } else {
                var wrapper = document.createElement('div');
                wrapper.setAttribute('id', divID);                
            }
            wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            alertPlaceholder.append(wrapper);
        }
    </script>
</div>