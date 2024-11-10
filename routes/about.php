<?php
    session_start();
    $is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    $logout_link = $is_logged_in ? '<a href="../includes/logout.php">Logout</a>' : '<a id="login-or-logout" href="login.php">Login</a>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        :root {
            --imperial-gold: #EFBF04;
            --dark-bg: rgba(20, 20, 20, 0.95);
        }

        body {
            background: var(--dark-bg);
            color: white;
            font-family: "Crimson Text", serif;
            margin: 0;
            padding: 0;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1rem;
            background: var(--dark-bg);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            border-bottom: 1px solid rgba(239, 191, 4, 0.2);
        }

        .clickable-home {
            color: var(--imperial-gold);
            text-decoration: none;
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            text-shadow: 0 0 10px rgba(239, 191, 4, 0.3);
            transition: all 0.3s ease;
        }

        .clickable-home:hover {
            color: #FFD700;
            text-shadow: 0 0 15px rgba(239, 191, 4, 0.5);
        }

        #navigation {
            display: flex;
            gap: 1rem;
        }

        #navigation a {
            color: var(--imperial-gold);
            text-decoration: none;
            font-size: clamp(1rem, 2vw, 1.5rem);
            transition: all 0.3s ease;
            padding: 0.5rem;
            border-radius: 4px;
        }

        #navigation a:hover {
            background: rgba(239, 191, 4, 0.1);
        }

        .team-section {
            margin-top: 120px;
            padding: 2rem;
            text-align: center;
        }

        .team-section h1 {
            color: var(--imperial-gold);
            margin-bottom: 3rem;
            font-size: clamp(2rem, 5vw, 3.5rem);
            text-shadow: 0 0 15px rgba(239, 191, 4, 0.3);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .member-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(239, 191, 4, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(239, 191, 4, 0.2);
        }

        .member-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--imperial-gold);
            box-shadow: 0 0 15px rgba(239, 191, 4, 0.3);
        }

        .member-card h6 {
            color: var(--imperial-gold);
            font-size: 1.25rem;
            margin: 0.5rem 0;
        }

        .member-card p {
            color: #ffffff;
            opacity: 0.8;
            margin: 0;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .header {
                padding: 0.75rem;
            }

            .team-section {
                margin-top: 100px;
                padding: 1rem;
            }

            .member-picture {
                width: 150px;
                height: 150px;
            }

            .team-grid {
                gap: 1.5rem;
                padding: 0 0.5rem;
            }
        }
    </style>
    <title>About - Meet the Team</title>
</head>
<body>
    <div class="header">    
        <a href='../index.php' class='clickable-home'>THE IMPERIUM 40K</a>
        <nav id="navigation"> 
            <a href="../index.php">Factions</a>
            <?php echo $logout_link;?>
        </nav>
    </div>

    <main class="team-section">
        <h1>Meet the Team</h1>
        <div class="team-grid">
            <div class="member-card">
                <img class="member-picture" src="../assets/images/members/ken.png" alt="Ken Shamrock Dizon">
                <h6>Ken Shamrock Dizon</h6>
                <p>Full Stack Developer</p>
            </div>
            <div class="member-card">
                <img class="member-picture" src="../assets/images/members/fred.png" alt="Fred Jaafaray">
                <h6>Fred Jaafaray</h6>
                <p>Front End Developer and Designer</p>
            </div>
            <div class="member-card">
                <img class="member-picture" src="../assets/images/members/web.jpg" alt="Webster Pangan">
                <h6>Webster Pangan</h6>
                <p>Cloud Engineer and Back End Developer</p>
            </div>
            <div class="member-card">
                <img class="member-picture" src="../assets/images/members/pat.jpg" alt="Patrick Charles Simbahan">
                <h6>Patrick Charles Simbahan</h6>
                <p>Front End Developer and Designer</p>
            </div>
            <div class="member-card">
                <img class="member-picture" src="../assets/images/members/clyde.png" alt="Clyde Vincent Viray">
                <h6>Clyde Vincent Viray</h6>
                <p>Back End Developer and Database Administrator</p>
            </div>
            <div class="member-card">
                <img class="member-picture" src="../assets/images/members/charles.jpg" alt="Charles Darrel Collado">
                <h6>Charles Darrel Collado</h6>
                <p>Front End Developer and Designer</p>
            </div>
        </div>
    </main>
</body>
</html>