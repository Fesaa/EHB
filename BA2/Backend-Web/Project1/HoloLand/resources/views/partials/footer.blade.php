<link rel="stylesheet" href="{{ asset('css/partials/footer.css') }}">

<footer class="curvetop">

    <div class="footer-holder flex-row">
        <div class="footer-item flex-column">
            <div class="footer-item">
                <h3>About me</h3>
                <p>I'm a website made for the Backend Web 2023 Course on the EHB.
                    With heavy layout inspiration from <a class="footer-link" href="https://www.cubecraft.net/" target="_blank">CubeCraft</a>
                    , and the name from <a class="footer-link" href="https://spice-and-wolf.com/" target="_blank">Spice and Wolf</a>.
                </p>
            </div>
            <div class="footer-item">
                <h3>Handy Links!</h3>
                <ul class="flat-list">
                    <li><a class="footer-link" href="{{ route('forums.show', 4) }}">FAQ</a></li>
                    <li><a class="footer-link" href="{{ route('threads.show', 7) }}">Rules</a></li>
                    <li><a class="footer-link" href="{{ route('forums.show', 5) }}">Support</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
