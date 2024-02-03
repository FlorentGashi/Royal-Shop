<!-- Here is The Loader so The Page Doesn't show up till the content is Loaded -->
<div class="center-body" id="loading">
    <div class="loader-circle-86">
        <svg version="1.1" x="0" y="0" viewbox="-10 -10 120 120" enable-background="new 0 0 200 200" xml:space="preserve">
        <path class="circle" d="M0,50 A50,50,0 1 1 100,50 A50,50,0 1 1 0,50"/>
        </svg>
    </div>
</div>

<script>
        window.addEventListener('load', function() {
            document.getElementById('loading').classList.add('hide');
        });
</script>