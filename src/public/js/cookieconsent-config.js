import 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.0/dist/cookieconsent.umd.js';

CookieConsent.run({
    guiOptions: {
        consentModal: {
            layout: "box",
            position: "bottom left",
            equalWeightButtons: true,
            flipButtons: false
        },
        preferencesModal: {
            layout: "box",
            position: "right",
            equalWeightButtons: true,
            flipButtons: false
        }
    },
    categories: {
        necessary: {
            readOnly: true
        },
        functionality: {},
        analytics: {},
        performance: {}
    },
    language: {
        default: "cs",
        autoDetect: "browser",
        translations: {
            en: {
                consentModal: {
                    title: '<img src="https://autumn.fluffici.eu/attachments/ystmRycjgISxQse2DtDbZ0O9UD7IIs5QomOCbQHwPd" alt="Your Alt Text" style="width: 65px;margin-right: 10px;">Hello traveller, it\'s cookie time!',
                    description: "Our website uses cookies to enhance your browsing experience. A cookie is a small file stored on your device, allowing us to recognize and remember you when you return to our website. These cookies cover a variety areas.",
                    acceptAllBtn: "Accept all",
                    acceptNecessaryBtn: "Reject all",
                    showPreferencesBtn: "Manage preferences",
                    footer: "<a href=\"https://fluffici.eu/privacy\">Privacy Policy</a>\n<a href=\"https://fluffici.eu/tos\">Terms And Conditions</a>"
                },
                preferencesModal: {
                    title: "Consent Preferences Center",
                    acceptAllBtn: "Accept all",
                    acceptNecessaryBtn: "Reject all",
                    savePreferencesBtn: "Save preferences",
                    closeIconLabel: "Close modal",
                    serviceCounterLabel: "Service|Services",
                    sections: [
                        {
                            title: "Strictly Necessary Cookies <span class=\"pm__badge\">Always Enabled</span>",
                            description: "Critical for us to provide our services. They include cookies that enable you to log into secure sections of our website.",
                            linkedCategory: "necessary"
                        },
                        {
                            title: "Functionality Cookies",
                            description: "Enable us to optimize our website functionality by remembering your choices. This includes cookies that remember your language and region.",
                            linkedCategory: "functionality"
                        },
                        {
                            title: "Performance Cookies",
                            description: "We use these to analyze how our website is being accessed, used, or is performing. We use this information to maintain, operate and improve our website.",
                            linkedCategory: "performance"
                        },
                        {
                            title: "Analytics Cookies",
                            description: "These help us to serve you more relevant ads and enhance your internet experience.",
                            linkedCategory: "analytics"
                        },
                        {
                            title: "More information",
                            description: "For any query in relation to my policy on cookies and your choices, please <a class=\"cc__link\" href=\"mailto:administrace@fluffici.eu\">contact us</a>."
                        }
                    ]
                }
            },

            cs: {
                consentModal: {
                    title: '<img src="https://autumn.fluffici.eu/attachments/ystmRycjgISxQse2DtDbZ0O9UD7IIs5QomOCbQHwPd" alt="Ilustrace našeho maskota" style="width: 65px;margin-right: 10px;">Vítej na webu, dáš si sušenku?',
                    description: "Náš web používá cookies ke zlepšení tvého uživatelského zážitku. Cookies jsou malé soubory uložené na tvém zařízení, umožňující nám rozeznat a zapamatovat si tě, kdykoli se na náš web navrátíš. Takové cookies pokrývá mnoho různých oblastí.",
                    acceptAllBtn: "Přijmout všechny",
                    acceptNecessaryBtn: "Odmítnout všechny",
                    showPreferencesBtn: "Přizpůsobit dle preference",
                    footer: "<a href=\"https://fluffici.eu/privacy\">Privacy Policy</a>\n<a href=\"https://fluffici.eu/tos\">Terms And Conditions</a>"
                },
                preferencesModal: {
                    title: "Správa cookies preferencí",
                    acceptAllBtn: "Přijmout všechny",
                    acceptNecessaryBtn: "Odmítnout všechny",
                    savePreferencesBtn: "Uložit preference",
                    closeIconLabel: "Zavřít okno",
                    serviceCounterLabel: "Služba|Služby",
                    sections: [
                        {
                            title: "Striktně důležité cookies <span class=\"pm__badge\">Vždy povoleno</span>",
                            description: "Kritické pro poskytování našich služeb. Zahrnují cookies umožňující přihlášení k zabezpečeným částem webu.",
                            linkedCategory: "nezbytné"
                        },
                        {
                            title: "Provozní cookies",
                            description: "Dovol nám optimalizovat funkcionalitu našeho webu tak, že si zapamatujeme tvůj jazyk a oblast.",
                            linkedCategory: "funkcionalita"
                        },
                        {
                            title: "Výkonové cookies",
                            description: "Tyto cookies užíváme k analýze, jak je k našemu webu přistupováno, jak je používán nebo jak si vede výkonově. Tyto informace používáme k údržbě, úpravě a zlepšenování našeho webu.",
                            linkedCategory: "výkon"
                        },
                        {
                            title: "Analytické cookies",
                            description: "Pomáhají nám ti zajišťovat více relevantní reklamny a zlepšovat tak tvé internetové brouzdání.",
                            linkedCategory: "analytics"
                        },
                        {
                            title: "Více informací",
                            description: "Jakékoli otázky ohledně cookies a svých voleb směřuj na <a class=\"cc__link\" href=\"mailto:administrace@fluffici.eu\">náš administrační email</a>."
                        }
                    ]
                }
            }
        }
    },
    disablePageInteraction: true
});
