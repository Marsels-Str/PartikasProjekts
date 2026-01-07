Tālāk rakstītais ir domāts personām ar iepriekšēju pieredzi programmēšanā un virtuālo serveru uzstādīšanā!

1. Iejiet sev tīkamā mapē vai izveidot ar "mkdir" un mapes nosaukums, tad klonēt projektu ar "git clone" un github saiti - https://github.com/Parvaldnieks/PartikasProjekts.git

2. Tad iejiet šajā projekta mapē un pēc kārtas izmantot šīs komandas "composer i" un "npm i"

3. Atvērt VSC, ja tas tiek izmantots, ja nē tad citu sev tīkamo koda rakstīšanas lietotni un atvērt ".env.example" failu un atkomentēt visas līnijas kuras sākas ar "DB"

4. ja grib, tad var nomainit nosaukumu datubāzei, kā arī ja ir tad izmantot savu paroli

4. Izveidot datubāzi ar "php artisan migrate", vēlāk, lai attiestatītu datubāzi izmantot "php artisan migrate:fresh"

5. Izveidot projekta atslēgu ar "php artisan key:generate"

6. Tad atsevišķos termināļos izmantot "php artisan serve" un "npm run dev"

Tūlkošanas poga nestrādās, jo tai ir nepieciešams API par maksu un tas šeit netiks norādīts,
bet ja grib tad var izveidot savu atslēgu ejot uz - https://cloud.google.com/translate

Takā https://world.openfoodfacts.org/ API ir par brīvu tas netika izmantots .env failā,
bet gan pa taisno "hard-coded" produktu kontrolierī - app/Http/Controllers/ProductController.php
