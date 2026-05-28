<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="src/img/tikus.png" type="image/x-icon">
    <title>Monitoring Tikus</title>
</head>
<body class="bg-base-200 min-h-screen flex flex-col">
    <header>
        <!-- Navbar -->
        <div class="navbar border-b bg-base-200 border-base-200 px-4 md:px-10 shadow-sm">
            <div class="flex-1">
                <a href="index.php" class="flex items-center gap-2">
                    <img src="src/img/tikus.png" class="w-8 h-8"/>
                    <div class="flex">
                        <span class="text-xl italic font-bold tracking-tight">MONITORING</span>
                        <span class="text-xl italic font-bold tracking-tight text-primary">TIKUS</span>
                    </div>
                </a>
            </div>
            <div class="flex-none">
                <!-- Mobile Menu -->
                <div class="dropdown dropdown-end md:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <i class="fas fa-bars text-xl"></i>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-200 rounded-box w-52 border border-base-200">
                        <li><a href="views/contents/sampel.php">Sampel</a></li>
                        <li><a href="views/contents/tikus.php">Tikus</a></li>
                        <li><a href="views/contents/monitoring.php" class="text-primary font-bold">Mulai</a></li>
                    </ul>
                </div>
                <!-- Desktop Menu -->
                <ul class="menu menu-horizontal px-1 font-medium hidden md:flex">
                    <li><a href="views/contents/sampel.php">Sampel</a></li>
                    <li><a href="views/contents/tikus.php">Tikus</a></li>
                    <li><a href="views/contents/monitoring.php" class="btn btn-primary btn-sm text-white px-4 ml-2">Mulai</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <div class="hero flex-grow bg-base-100 px-4 py-10">
            <div class="hero-content text-center">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-6xl font-black mb-6">Monitoring Tikus<br><span class="text-primary text-3xl md:text-5xl">Uji Kelayakan Sediaan</span></h1>
                    <p class="text-base md:text-lg italic opacity-100 leading-relaxed mb-10">"UJI TOKSISITAS AKUT DERMAL FILM FORMING GEL EXTRAK LIDAH MERTUA (Sansevieria trifasciata Prain) SECARA IN VIVO"</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="views/contents/monitoring.php" class="btn btn-primary btn-lg px-8 w-full md:w-auto">Input Data Harian</a>
                        <a href="views/contents/monitoring.php" class="btn btn-ghost btn-lg px-8 border border-base-300 w-full md:w-auto">Lihat Riwayat</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 md:mt-20 text-left py-10">
                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-none">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">14 Hari</h3>
                                <p class="text-sm opacity-60">Periode pengujian sediaan rutin.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary flex-none">
                                <i class="fas fa-weight"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Data Berat</h3>
                                <p class="text-sm opacity-60">Log harian berat badan tikus.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center text-accent flex-none">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Cek Kulit</h3>
                                <p class="text-sm opacity-60">Pantau iritasi melalui foto.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer sm:footer-horizontal footer-center bg-base-200 text-base-content p-4">
        <aside>
            <p class="font-semibold">Copyright ©2026 - PratamaCode</p>
        </aside>
    </footer>
</body>
</html>