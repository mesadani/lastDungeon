@extends('layout.general')
@section('header')


@endsection
@section('content')

    <style>

        .content-container {
            width: 100%;
        }
        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .market-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .nft-card {
            background-color: #2c2c2c;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .nft-card:hover {
            transform: scale(1.05);
        }
        .nft-card img {
            width: 100%;
            max-width: 200px;
            border-radius: 10px;
        }
        .nft-card h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .medieval-button {
            padding: 8px 15px;
            background-color: #795649;
            border: none;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            margin: 5px;
            border-radius: 5px;
        }
        .medieval-button:hover {
            background-color: #8a6e2f;
        }
    </style>
        <div class="content-container">
            <div class="filter-container">
                <select>
                    <option value="all">Type</option>
                    <option value="sword">Sword</option>
                    <option value="shield">Shield</option>
                    <option value="craft">Craft</option>
                </select>
                <select>
                    <option value="high">Price: High to Low</option>
                    <option value="low">Price: Low to High</option>
                </select>
                <input type="text" placeholder="Search by name">
                <button class="medieval-button">Apply</button>
            </div>
            <div class="market-container">
                <script>
                    for (let i = 1; i <= 18; i++) {
                        document.write(`
                        <div class="nft-card">
                            <img src="nft/nft1.png" alt="NFT ${i}">
                            <h3 class="nft-title">NFT #${i}</h3>
                            <button class="medieval-button">Buy</button>
                            <button class="medieval-button">Details</button>
                        </div>
                    `);
                    }
                </script>
            </div>
        </div>


@endsection
