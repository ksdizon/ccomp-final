<?php
    session_start();

    // Display alerts for debugging (optional)
    //echo "<script>alert('" . $_SESSION['username'] . "');</script>";
    //echo "<script>alert('" . isset($_SESSION['logged_in']) . "');</script>";
    //echo "<script>alert('" . $_SESSION['age'] ."');</script>";
    //echo "<script>alert('" . $_SESSION['gender'] ."');</script>";

    // Include tracking data
    include 'includes/ad_assigner.php';

    // Check if the user is logged in
    $is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

    if ($is_logged_in) {
        // Logout link clears the session
        $random_ad = ads_for_users($_SESSION['age'], $_SESSION['gender']);
        $logout_link = '<a href="includes/logout.php">Logout</a>';
    } else {
        // Login link
        $random_ad = ads_for_guests();
        $logout_link = '<a id="login-or-logout" href="routes/login.php">Login</a>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Imperium 40K</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">    
        <a href='#' class='clickable-home'>THE IMPERIUM 40K</a>
        <nav id="navigation"> 
            <a href="#Factions">Factions</a>
            <a href="routes/about.php">About</a>
            <?php echo $logout_link; ?>
        </nav>
    </div>
    
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">FOR THE EMPEROR</h1>
            <p class="hero-subtitle">In the grim darkness of the far future, there is only war</p>
            <a href="#About" class="btn btn-outline-warning btn-lg">Enter the Imperium</a>
        </div>
    </section>

    <div class="about" id="About">
        <h3>Welcome to the Imperium 40K</h3>
        <p>Welcome to The Imperium40k, your ultimate portal to the sprawling universe of Warhammer 40,000. Our site is dedicated to bringing you the vast lore, gameplay strategies, and community insights that make the Warhammer 40K universe so captivating. Here, you’ll delve into the rich history of humanity’s struggle for survival amidst a galaxy teeming with hostile xenos, treacherous traitors, and the corrupting forces of Chaos. From the epic triumphs of the Great Crusade, led by the Emperor and His Primarchs, to the devastating civil war of the Horus Heresy, and through to the grim reality of the 41st Millennium, where the Imperium stands as a fortress in an endless war for existence, you’ll uncover it all.</p>
        <p>Beyond the battlefield, the Warhammer 40K universe offers a rich tapestry of stories, characters, and philosophies. Our website also explores the deeper narratives behind each faction, from the ancient mysteries of the Necrons to the ruthless efficiency of the T'au Empire, and the grim determination of the Astra Militarum. Whether you're here for the lore, strategy, or hobbyist inspiration, The Imperium40k is your gateway to one of the most immersive universes in science fiction, where every battle fought has an impact on the fate of the galaxy.</p>
        <p>Our website is designed to cater to all types of fans. Whether you're a seasoned player who has led countless armies into the fray, familiar with every rule and strategy of the tabletop game, or a newcomer eager to explore the gothic grandeur and dark future of 40K, we've got something for you.</p>
    </div>

    <section class="faction-grid" id="Factions">
        <div class="faction-card">
            <i class="fas fa-crown faction-icon"></i>
            <h3>Space Marines</h3>
            <p>Space Marines are the elite defenders of the Imperium, created by the Emperor to safeguard humanity. Genetically enhanced and rigorously trained, they possess unmatched combat prowess and discipline. Each Space Marine belongs to a Chapter, bound by strict codes of honor and duty. Their power armor and advanced weaponry make them formidable on the battlefield, where they face xenos, heretics, and the forces of Chaos. With unwavering loyalty to the Emperor, they strike where the Imperium is most threatened. These warriors are the last line of defense, standing as humanity’s shield against the darkness that seeks to engulf the galaxy.</p>        </div>
        <div class="faction-card">
            <i class="fas fa-skull faction-icon"></i>
            <h3>Chaos Space Marines</h3>
            <p>Once noble soldiers, now twisted by darkness, the Chaos Space Marines are renegades who have forsaken the Emperor. Driven by hatred and the temptations of the Warp, they serve the Chaos Gods in their quest to bring destruction. Once organized under the Imperium, they now exist in warbands, following their dark lords or falling into madness. Their corrupted armor, warped by the dark powers, reflects the brutal nature of their rebellion. Seeking revenge, they target not only the Imperium but all who stand in their path, spreading war and chaos across the galaxy.</p>        </div>
        <div class="faction-card">
            <i class="fas fa-robot faction-icon"></i>
            <h3>Adeptus Mechanicus</h3>
            <p>The Adeptus Mechanicus is a mysterious and powerful organization within the Imperium, dedicated to the pursuit of knowledge and the worship of the Machine God. Based on the forge world of Mars, they are responsible for creating and maintaining the advanced technology of the Imperium. Their Tech-Priests are highly skilled engineers, capable of constructing everything from starships to weapons of war. Unlike the rest of the Imperium, they view technology as sacred, believing that each machine has a spirit that must be honored. The Adeptus Mechanicus wields vast influence, with their armies of Skitarii and massive Titans supporting Imperial campaigns.</p>        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Watch an ad to support the Imperium</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="videoPlayer" width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $random_ad;?>?enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player;
        
        // This function creates an <iframe> (and YouTube player)
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('videoPlayer', {
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            // Video is ready to be played
        }

        function onPlayerStateChange(event) {
            // You can handle state changes here if needed
        }

        // Handle modal events
        document.addEventListener('DOMContentLoaded', function() {
            const videoModalElement = document.getElementById('videoModal');
            const videoModal = new bootstrap.Modal(videoModalElement);
            
            // Show the modal on page load
            videoModal.show();
            
            // Use Bootstrap's Modal events to listen for hide event
            videoModalElement.addEventListener('hidden.bs.modal', function () {
                if (player && typeof player.stopVideo === 'function') {
                    player.stopVideo(); // Stop the video completely
                    // Additional cleanup: set src to empty to ensure video stops
                    const iframe = document.getElementById('videoPlayer');
                    if (iframe) {
                        const src = iframe.src;
                        iframe.src = '';
                        setTimeout(() => {
                            iframe.src = src;
                        }, 100);
                    }
                }
            });

            // Also handle when modal is being hidden
            videoModalElement.addEventListener('hide.bs.modal', function () {
                if (player && typeof player.stopVideo === 'function') {
                    player.stopVideo();
                }
            });
        });
    </script>
</body>
</html>