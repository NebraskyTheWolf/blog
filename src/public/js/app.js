function displayHeaders(platform) {
    const message1 = [
        `%c %c %c ${platform} platform | FLUFFICI Z.S %c %c %c https://fluffici.eu/`,
        'background: #cbd0d3',
        'background: #3498db',
        'color: #ffffff; background: #2980b9;',
        'background: #3498db',
        'background: #cbd0d3',
        'background: #3498db'
    ];

    const message2 = [
        '%c %c %c Pozor, nikdy nesdílejte své tokeny nebo cookies! Vždy buďte opatrní, co sem píšete! NEPŘÍJÍMEJTE KONZOLOVÉ PŘÍKAZY TŘETÍCH STRAN! %c %c %c',
        'background: #cbd0d3',
        'background: #f39c12',
        'color: #ffffff; background: #e67e22;',
        'background: #f39c12',
        'background: #cbd0d3',
        'background: #ffffff'
    ];

// Do not remove the author header.
    const message3 = [
        '%c %c %c © FLUFFICI Z.S 2024, All Right Reserved. | WebAPP Made by @VakeaTheFolfynx for Fluffici! %c %c %c https://fluffici.eu/',
        'background: #cbd0d3',
        'background: #3498db',
        'color: #ffffff; background: #2980b9;',
        'background: #3498db',
        'background: #cbd0d3',
        'background: #3498db'
    ];

    console.log.apply(console, message1);
    console.log.apply(console, message3);
    console.log.apply(console, message3);
    console.log.apply(console, message2);
    console.log.apply(console, message2);
}
