<div class="loader"></div>
<script>
    function showLoading() {
        $('.loader').show();
    }

    function hideLoading() {
        $('.loader').hide();
    }
</script>
<style>
    .loader {
        /* background-color: rgba(235, 15, 15, 0.5); */
        z-index: 9999;
        display: none;
        position: absolute;
        top: 50%;
        left: 40%;
        width: 100px;
        height: 100px;
        aspect-ratio: 1;
        position: relative;
    }

    .loader:before,
    .loader:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        margin: -8px 0 0 -8px;
        width: 25px;
        aspect-ratio: 1;
        background: #3FB8AF;
        animation:
            l1-1 2s infinite,
            l1-2 .5s infinite;
    }

    .loader:after {
        background: #FF3D7F;
        animation-delay: -1s, 0s;
    }

    @keyframes l1-1 {
        0% {
            top: 0;
            left: 0
        }

        25% {
            top: 100%;
            left: 0
        }

        50% {
            top: 100%;
            left: 100%
        }

        75% {
            top: 0;
            left: 100%
        }

        100% {
            top: 0;
            left: 0
        }
    }

    @keyframes l1-2 {

        80%,
        100% {
            transform: rotate(0.5turn)
        }
    }
</style>
