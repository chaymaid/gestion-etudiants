@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">
            ✏️ Modifier note Quran
        </div>

        <div class="card-body">

            @php
            $sourates = [
                "Al-Fatiha","Al-Baqara","Aal-Imran","An-Nisa","Al-Ma'idah","Al-An'am","Al-A'raf","Al-Anfal","At-Tawbah","Yunus",
                "Hud","Yusuf","Ar-Ra'd","Ibrahim","Al-Hijr","An-Nahl","Al-Isra","Al-Kahf","Maryam","Ta-Ha",
                "Al-Anbiya","Al-Hajj","Al-Mu'minun","An-Nur","Al-Furqan","Ash-Shu'ara","An-Naml","Al-Qasas","Al-Ankabut","Ar-Rum",
                "Luqman","As-Sajdah","Al-Ahzab","Saba","Fatir","Ya-Sin","As-Saffat","Sad","Az-Zumar","Ghafir",
                "Fussilat","Ash-Shura","Az-Zukhruf","Ad-Dukhan","Al-Jathiyah","Al-Ahqaf","Muhammad","Al-Fath","Al-Hujurat","Qaf",
                "Adh-Dhariyat","At-Tur","An-Najm","Al-Qamar","Ar-Rahman","Al-Waqi'ah","Al-Hadid","Al-Mujadila","Al-Hashr","Al-Mumtahanah",
                "As-Saff","Al-Jumu'ah","Al-Munafiqun","At-Taghabun","At-Talaq","At-Tahrim","Al-Mulk","Al-Qalam","Al-Haqqah","Al-Ma'arij",
                "Nuh","Al-Jinn","Al-Muzzammil","Al-Muddathir","Al-Qiyamah","Al-Insan","Al-Mursalat","An-Naba","An-Nazi'at","Abasa",
                "At-Takwir","Al-Infitar","Al-Mutaffifin","Al-Inshiqaq","Al-Buruj","At-Tariq","Al-A'la","Al-Ghashiyah","Al-Fajr","Al-Balad",
                "Ash-Shams","Al-Layl","Ad-Duha","Ash-Sharh","At-Tin","Al-Alaq","Al-Qadr","Al-Bayyinah","Az-Zalzalah","Al-Adiyat",
                "Al-Qari'ah","At-Takathur","Al-Asr","Al-Humazah","Al-Fil","Quraysh","Al-Ma'un","Al-Kawthar","Al-Kafirun","An-Nasr",
                "Al-Masad","Al-Ikhlas","Al-Falaq","An-Nas"
            ];
            @endphp

            <form action="{{ route('quran.update', $quran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- SOURATE -->
                <div class="mb-3">
                    <label>Sourate</label>
                    <select name="sourate" class="form-control">

                        @foreach($sourates as $index => $s)
                            <option value="{{ $s }}" {{ $quran->sourate == $s ? 'selected' : '' }}>
                                {{ $index+1 }} - {{ $s }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- HIZB -->
                <div class="mb-3">
                    <label>Hizb</label>
                    <input type="text" name="hizb" value="{{ $quran->hizb }}" class="form-control">
                </div>

                <!-- JUZ -->
                <div class="mb-3">
                    <label>Juz</label>
                    <input type="text" name="juz" value="{{ $quran->juz }}" class="form-control">
                </div>

                <!-- TYPE -->
                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="memorisation" {{ $quran->type == 'memorisation' ? 'selected' : '' }}>Mémorisation</option>
                        <option value="recitation" {{ $quran->type == 'recitation' ? 'selected' : '' }}>Récitation</option>
                    </select>
                </div>

                <!-- NOTE -->
                <div class="mb-3">
                    <label>Note</label>
                    <input type="number" name="note" value="{{ $quran->note }}" class="form-control">
                </div>

                <!-- DATE -->
                <div class="mb-3">
                    <label>Date</label>
                    <input type="date" name="date" value="{{ $quran->date }}" class="form-control">
                </div>

                <!-- REMARQUE -->
                <div class="mb-3">
                    <label>Remarque</label>
                    <textarea name="remarque" class="form-control">{{ $quran->remarque }}</textarea>
                </div>

                <button class="btn btn-warning">Modifier</button>

            </form>

        </div>

    </div>

</div>

@endsection
