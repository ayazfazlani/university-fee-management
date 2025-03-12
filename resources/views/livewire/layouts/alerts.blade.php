<div
    x-data="{ show: @entangle('visible') }"
    x-show="show"
    x-transition
    x-init="$wire.on('alert:hide', () => { setTimeout(() => show = false, 5000); })"
    class="fixed-alerts alert 
        @if ($type == 1) 
            alert-success 
        @elseif ($type == 2) 
            alert-danger 
        @elseif ($type == 3) 
            alert-warning 
        @elseif ($type == 5) 
            alert-info 
        @elseif ($type == 5) 
            alert-primary 
        @elseif ($type == 6) 
            alert-secondary 
        @elseif ($type == 7) 
            alert-dark
        @else
            alert-primary
        @endif
        alert-dismissible
        
         "
    role="alert"
    style="display: none;"
>
    <span class="block">{{ $message }}</span>
    <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
</div>
