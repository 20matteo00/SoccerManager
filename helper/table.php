<?php

class Table
{
    private $db;
    private $continenti = [
        'Europa',
        'America Sud',
        'America Nord',
        'Africa',
        'Asia',
        'Oceania'
    ];
    private $stati_europa = [
        'Italia',
        'Francia',
        'Inghilterra',
        'Germania',
        'Spagna',
        'Portogallo',
        'Olanda',
        'Belgio',
        'Croazia',
        'Svizzera',
        'Danimarca',
        'Svezia',
        'Polonia',
        'Austria',
        'Norvegia',
        'Serbia',
        'Cechia',
        'Ungheria',
        'Slovacchia',
        'Scozia',
        'Finlandia',
        'Slovenia',
        'Ucraina',
        'Grecia'
    ];

    private $stati_america_sud = [
        'Brasile',
        'Argentina',
        'Uruguay',
        'Colombia',
        'Cile',
        'Perù',
        'Ecuador',
        'Paraguay',
        'Bolivia',
        'Venezuela'
    ];

    private $stati_america_nord = [
        'Messico',
        'Stati Uniti',
        'Costa Rica',
        'Canada',
        'Panama',
        'Giamaica',
        'Honduras',
        'El Salvador',
        'Guatemala',
        'Trinidad e Tobago'
    ];

    private $stati_africa = [
        'Egitto',
        'Marocco',
        'Senegal',
        'Costa d\'Avorio',
        'Nigeria',
        'Tunisia',
        'Algeria',
        'Ghana',
        'Sudafrica',
        'Camerun',
        'Mali',
        'RD Congo',
        'Burkina Faso',
        'Zambia',
        'Guinea'
    ];

    private $stati_asia = [
        'Giappone',
        'Corea del Sud',
        'Arabia Saudita',
        'Iran',
        'Australia', // in AFC, quindi lo includiamo qui
        'Qatar',
        'Uzbekistan',
        'Cina',
        'Iraq',
        'Emirati Arabi Uniti',
        'Giordania',
        'India',
        'Thailandia',
        'Oman'
    ];

    private $stati_oceania = [
        'Nuova Zelanda',
        'Isole Salomone',
        'Figi',
        'Nuova Caledonia',
        'Papua Nuova Guinea',
        'Tahiti',
        'Vanuatu'
    ];

    private $competizioni = [
        ['nome' => 'Coppa del Mondo',       'stato' => 'Mondo'],  // Mondo
        ['nome' => 'Olimpiadi',             'stato' => 'Mondo'],  // Mondo

        // Europa
        ['nome' => 'Europeo',               'stato' => 'Europa'], // Europa
        ['nome' => 'UEFA Champions League', 'stato' => 'Europa'], // Europa
        ['nome' => 'UEFA Europa League',    'stato' => 'Europa'], // Europa
        ['nome' => 'UEFA Conference League', 'stato' => 'Europa'], // Europa
        ['nome' => 'Supercoppa UEFA',       'stato' => 'Europa'], // Europa

        // Asia
        ['nome' => 'AFC Champions League', 'stato' => 'Asia'], // Asia
        ['nome' => 'Asian Cup',            'stato' => 'Asia'], // Asia
        ['nome' => 'K-League',             'stato' => 'Corea del Sud'], // Corea del Sud
        ['nome' => 'J-League',             'stato' => 'Giappone'], // Giappone

        // America del Sud
        ['nome' => 'Copa Libertadores',   'stato' => 'America del Sud'], // America del Sud
        ['nome' => 'Copa America',        'stato' => 'America del Sud'], // America del Sud
        ['nome' => 'Brasileirão',         'stato' => 'Brasile'], // Brasile
        ['nome' => 'Primera División',    'stato' => 'Argentina'], // Argentina
        ['nome' => 'Serie A',             'stato' => 'Perù'], // Perù
        ['nome' => 'Categoría Primera A', 'stato' => 'Colombia'], // Colombia

        // Africa
        ['nome' => 'Coppa d\'Africa',     'stato' => 'Africa'], // Africa
        ['nome' => 'Championship of African Nations', 'stato' => 'Africa'], // Africa

        // Oceania
        ['nome' => 'OFC Champions League', 'stato' => 'Oceania'], // Oceania
        ['nome' => 'New Zealand Football Championship', 'stato' => 'Nuova Zelanda'], // Nuova Zelanda
        ['nome' => 'O-League',             'stato' => 'Oceania'], // Oceania

        // Stati Uniti (America del Nord)
        ['nome' => 'MLS',                 'stato' => 'Stati Uniti'], // Stati Uniti
        ['nome' => 'US Open Cup',         'stato' => 'Stati Uniti'], // Stati Uniti
        ['nome' => 'Major League Soccer', 'stato' => 'Stati Uniti'], // Stati Uniti
        ['nome' => 'Liga MX',             'stato' => 'Messico'], // Messico
        ['nome' => 'Copa MX',             'stato' => 'Messico'], // Messico

        // Italia
        ['nome' => 'Serie A',             'stato' => 'Italia'],  // Italia
        ['nome' => 'Serie B',             'stato' => 'Italia'],  // Italia
        ['nome' => 'Serie C Girone A',    'stato' => 'Italia'],  // Italia
        ['nome' => 'Serie C Girone B',    'stato' => 'Italia'],  // Italia
        ['nome' => 'Serie C Girone C',    'stato' => 'Italia'],  // Italia
        ['nome' => 'Coppa Italia',        'stato' => 'Italia'],  // Italia
        ['nome' => 'Supercoppa Italiana', 'stato' => 'Italia'],  // Italia
        ['nome' => 'Coppa Italia Serie C', 'stato' => 'Italia'],  // Italia
        ['nome' => 'Primavera',           'stato' => 'Italia'],  // Italia (giovanili)
        ['nome' => 'Serie D',             'stato' => 'Italia'],  // Italia
        ['nome' => 'Campionato Nazionale Dilettanti', 'stato' => 'Italia'], // Italia
        ['nome' => 'Legapro',             'stato' => 'Italia'],  // Italia

        // Francia
        ['nome' => 'Ligue 1',             'stato' => 'Francia'], // Francia
        ['nome' => 'Ligue 2',             'stato' => 'Francia'], // Francia
        ['nome' => 'Coupe de France',     'stato' => 'Francia'], // Francia
        ['nome' => 'Trophée des Champions', 'stato' => 'Francia'], // Francia

        // Inghilterra
        ['nome' => 'Premier League',      'stato' => 'Inghilterra'], // Inghilterra
        ['nome' => 'Championship',        'stato' => 'Inghilterra'], // Inghilterra
        ['nome' => 'League One',          'stato' => 'Inghilterra'], // Inghilterra
        ['nome' => 'League Two',          'stato' => 'Inghilterra'], // Inghilterra
        ['nome' => 'FA Cup',              'stato' => 'Inghilterra'], // Inghilterra
        ['nome' => 'EFL Cup',             'stato' => 'Inghilterra'], // Inghilterra
        ['nome' => 'Community Shield',    'stato' => 'Inghilterra'], // Inghilterra

        // Spagna
        ['nome' => 'La Liga',             'stato' => 'Spagna'], // Spagna
        ['nome' => 'La Liga 2',           'stato' => 'Spagna'], // Spagna
        ['nome' => 'Copa del Rey',        'stato' => 'Spagna'], // Spagna
        ['nome' => 'Supercopa de España', 'stato' => 'Spagna'], // Spagna

        // Germania
        ['nome' => 'Bundesliga',          'stato' => 'Germania'], // Germania
        ['nome' => '2. Bundesliga',       'stato' => 'Germania'], // Germania
        ['nome' => 'DFB-Pokal',           'stato' => 'Germania'], // Germania
        ['nome' => 'Supercup',            'stato' => 'Germania'], // Germania

        // Portogallo
        ['nome' => 'Primeira Liga',       'stato' => 'Portogallo'], // Portogallo
        ['nome' => 'Taça de Portugal',   'stato' => 'Portogallo'], // Portogallo
        ['nome' => 'Supertaça Cândido de Oliveira', 'stato' => 'Portogallo'], // Portogallo

        // Olanda
        ['nome' => 'Eredivisie',          'stato' => 'Olanda'], // Olanda
        ['nome' => 'KNVB Cup',            'stato' => 'Olanda'], // Olanda
        ['nome' => 'Supercup',            'stato' => 'Olanda'], // Olanda

        // Belgio
        ['nome' => 'Pro League',          'stato' => 'Belgio'], // Belgio
        ['nome' => 'Beker van België',    'stato' => 'Belgio'], // Belgio

        // Croazia
        ['nome' => 'Prva HNL',            'stato' => 'Croazia'], // Croazia
        ['nome' => 'Croatian Cup',        'stato' => 'Croazia'], // Croazia

        // Svezia
        ['nome' => 'Allsvenskan',         'stato' => 'Svezia'], // Svezia
        ['nome' => 'Svenska Cupen',       'stato' => 'Svezia'], // Svezia

        // Polonia
        ['nome' => 'Ekstraklasa',         'stato' => 'Polonia'], // Polonia
        ['nome' => 'Puchar Polski',       'stato' => 'Polonia'], // Polonia

        // Grecia
        ['nome' => 'Super League Greece', 'stato' => 'Grecia'], // Grecia
        ['nome' => 'Greek Cup',           'stato' => 'Grecia'], // Grecia

        // Turchia
        ['nome' => 'Süper Lig',           'stato' => 'Turchia'], // Turchia
        ['nome' => 'Türkiye Kupası',      'stato' => 'Turchia'], // Turchia

        // Ucraina
        ['nome' => 'Ukrainian Premier League', 'stato' => 'Ucraina'], // Ucraina
        ['nome' => 'Ukrainian Cup',           'stato' => 'Ucraina'], // Ucraina
    ];


    private $squadre = [
        ['nome' => 'Juventus', 'stato' => 'Italia'],
        ['nome' => 'Milan', 'stato' => 'Italia'],
        ['nome' => 'Inter', 'stato' => 'Italia'],
        ['nome' => 'Roma', 'stato' => 'Italia'],
        ['nome' => 'Lazio', 'stato' => 'Italia'],
        ['nome' => 'Napoli', 'stato' => 'Italia'],
        ['nome' => 'Atalanta', 'stato' => 'Italia'],
        ['nome' => 'Torino', 'stato' => 'Italia'],
        ['nome' => 'Fiorentina', 'stato' => 'Italia'],
        ['nome' => 'Genoa', 'stato' => 'Italia'],
        ['nome' => 'Sampdoria', 'stato' => 'Italia'],
        ['nome' => 'Bologna', 'stato' => 'Italia'],
        ['nome' => 'Cagliari', 'stato' => 'Italia'],
        ['nome' => 'Sassuolo', 'stato' => 'Italia'],
        ['nome' => 'Empoli', 'stato' => 'Italia'],
        ['nome' => 'Salernitana', 'stato' => 'Italia'],
        ['nome' => 'Lecce', 'stato' => 'Italia'],
        ['nome' => 'Monza', 'stato' => 'Italia'],
        ['nome' => 'Udinese', 'stato' => 'Italia'],
        ['nome' => 'Verona', 'stato' => 'Italia'],
        ['nome' => 'Cremonese', 'stato' => 'Italia'],
        ['nome' => 'Frosinone', 'stato' => 'Italia'],
        ['nome' => 'Spezia', 'stato' => 'Italia'],
        ['nome' => 'Bari', 'stato' => 'Italia'],
        ['nome' => 'Parma', 'stato' => 'Italia'],
        ['nome' => 'Palermo', 'stato' => 'Italia'],
        ['nome' => 'Catania', 'stato' => 'Italia'],
        ['nome' => 'Brescia', 'stato' => 'Italia'],
        ['nome' => 'Vicenza', 'stato' => 'Italia'],
        ['nome' => 'Ascoli', 'stato' => 'Italia'],
        ['nome' => 'Reggina', 'stato' => 'Italia'],
        ['nome' => 'Cosenza', 'stato' => 'Italia'],
        ['nome' => 'Pisa', 'stato' => 'Italia'],
        ['nome' => 'Ternana', 'stato' => 'Italia'],
        ['nome' => 'Cittadella', 'stato' => 'Italia'],
        ['nome' => 'Perugia', 'stato' => 'Italia'],
        ['nome' => 'Pordenone', 'stato' => 'Italia'],
        ['nome' => 'Reggiana', 'stato' => 'Italia'],
        ['nome' => 'Vicenza Virtus', 'stato' => 'Italia'],
        ['nome' => 'Mantova', 'stato' => 'Italia'],
        ['nome' => 'Triestina', 'stato' => 'Italia'],

        // Francia
        ['nome' => 'Paris Saint-Germain', 'stato' => 'Francia'],
        ['nome' => 'Olympique Marsiglia', 'stato' => 'Francia'],
        ['nome' => 'Lille', 'stato' => 'Francia'],
        ['nome' => 'Monaco', 'stato' => 'Francia'],
        ['nome' => 'Olympique Lione', 'stato' => 'Francia'],
        ['nome' => 'Stade Rennais', 'stato' => 'Francia'],
        ['nome' => 'Nizza', 'stato' => 'Francia'],
        ['nome' => 'Bordeaux', 'stato' => 'Francia'],
        ['nome' => 'Montpellier', 'stato' => 'Francia'],
        ['nome' => 'Strasburgo', 'stato' => 'Francia'],

        // Inghilterra 
        ['nome' => 'Liverpool', 'stato' => 'Inghilterra'],
        ['nome' => 'Manchester City', 'stato' => 'Inghilterra'],
        ['nome' => 'Chelsea', 'stato' => 'Inghilterra'],
        ['nome' => 'Arsenal', 'stato' => 'Inghilterra'],
        ['nome' => 'Tottenham Hotspur', 'stato' => 'Inghilterra'],
        ['nome' => 'Manchester United', 'stato' => 'Inghilterra'],
        ['nome' => 'West Ham United', 'stato' => 'Inghilterra'],
        ['nome' => 'Aston Villa', 'stato' => 'Inghilterra'],
        ['nome' => 'Leicester City', 'stato' => 'Inghilterra'],
        ['nome' => 'Everton', 'stato' => 'Inghilterra'],
        ['nome' => 'Newcastle United', 'stato' => 'Inghilterra'],
        ['nome' => 'Southampton', 'stato' => 'Inghilterra'],
        ['nome' => 'Wolverhampton', 'stato' => 'Inghilterra'],
        ['nome' => 'Crystal Palace', 'stato' => 'Inghilterra'],
        ['nome' => 'Brighton', 'stato' => 'Inghilterra'],

        // Germania
        ['nome' => 'Bayern Monaco', 'stato' => 'Germania'],
        ['nome' => 'Borussia Dortmund', 'stato' => 'Germania'],
        ['nome' => 'Lipsia', 'stato' => 'Germania'],
        ['nome' => 'Bayer Leverkusen', 'stato' => 'Germania'],
        ['nome' => 'Eintracht Francoforte', 'stato' => 'Germania'],
        ['nome' => 'Wolfsburg', 'stato' => 'Germania'],
        ['nome' => 'Borussia Mönchengladbach', 'stato' => 'Germania'],
        ['nome' => 'Freiburg', 'stato' => 'Germania'],
        ['nome' => 'Hoffenheim', 'stato' => 'Germania'],
        ['nome' => 'Hertha Berlino', 'stato' => 'Germania'],
        ['nome' => 'Colonia', 'stato' => 'Germania'],
        ['nome' => 'Stoccarda', 'stato' => 'Germania'],
        ['nome' => 'Mainz 05', 'stato' => 'Germania'],
        ['nome' => 'Augsburg', 'stato' => 'Germania'],
        ['nome' => 'Union Berlino', 'stato' => 'Germania'],

        // Spagna
        ['nome' => 'Real Madrid', 'stato' => 'Spagna'],
        ['nome' => 'Atletico Madrid', 'stato' => 'Spagna'],
        ['nome' => 'Barcelona', 'stato' => 'Spagna'],
        ['nome' => 'Sevilla', 'stato' => 'Spagna'],
        ['nome' => 'Real Betis', 'stato' => 'Spagna'],
        ['nome' => 'Valencia', 'stato' => 'Spagna'],
        ['nome' => 'Athletic Bilbao', 'stato' => 'Spagna'],
        ['nome' => 'Real Sociedad', 'stato' => 'Spagna'],
        ['nome' => 'Celta Vigo', 'stato' => 'Spagna'],
        ['nome' => 'Getafe', 'stato' => 'Spagna'],
        ['nome' => 'Espanyol', 'stato' => 'Spagna'],
        ['nome' => 'Granada', 'stato' => 'Spagna'],
        ['nome' => 'Osasuna', 'stato' => 'Spagna'],
        ['nome' => 'Alaves', 'stato' => 'Spagna'],
        ['nome' => 'Rayo Vallecano', 'stato' => 'Spagna'],
        ['nome' => 'Mallorca', 'stato' => 'Spagna'],
        ['nome' => 'Cádiz', 'stato' => 'Spagna'],
        ['nome' => 'Elche', 'stato' => 'Spagna'],
        ['nome' => 'Levante', 'stato' => 'Spagna'],
        ['nome' => 'Villarreal', 'stato' => 'Spagna'],
        ['nome' => 'Real Valladolid', 'stato' => 'Spagna'],
        ['nome' => 'Girona', 'stato' => 'Spagna'],
        ['nome' => 'Córdoba', 'stato' => 'Spagna'],
        ['nome' => 'Murcia', 'stato' => 'Spagna'],

        // Portogallo
        ['nome' => 'Benfica', 'stato' => 'Portogallo'],
        ['nome' => 'Porto', 'stato' => 'Portogallo'],
        ['nome' => 'Sporting Lisbona', 'stato' => 'Portogallo'],
        ['nome' => 'Braga', 'stato' => 'Portogallo'],
        ['nome' => 'Guimarães', 'stato' => 'Portogallo'],
        ['nome' => 'Marítimo', 'stato' => 'Portogallo'],
        ['nome' => 'Boavista', 'stato' => 'Portogallo'],
        ['nome' => 'Estoril Praia', 'stato' => 'Portogallo'],
        ['nome' => 'Tondela', 'stato' => 'Portogallo'],
        ['nome' => 'Moreirense', 'stato' => 'Portogallo'],
        ['nome' => 'Santa Clara', 'stato' => 'Portogallo'],
        ['nome' => 'Belenenses', 'stato' => 'Portogallo'],
        ['nome' => 'Arouca', 'stato' => 'Portogallo'],
        ['nome' => 'Famalicão', 'stato' => 'Portogallo'],
        ['nome' => 'Paços Ferreira', 'stato' => 'Portogallo'],
        ['nome' => 'Gil Vicente', 'stato' => 'Portogallo'],
        ['nome' => 'Vizela', 'stato' => 'Portogallo'],
        ['nome' => 'Casa Pia', 'stato' => 'Portogallo'],

        // Olanda
        ['nome' => 'Ajax', 'stato' => 'Olanda'],
        ['nome' => 'Feyenoord', 'stato' => 'Olanda'],
        ['nome' => 'PSV', 'stato' => 'Olanda'],
        ['nome' => 'AZ', 'stato' => 'Olanda'],
        ['nome' => 'Vitesse', 'stato' => 'Olanda'],
        ['nome' => 'Utrecht', 'stato' => 'Olanda'],
        ['nome' => 'Twente', 'stato' => 'Olanda'],
        ['nome' => 'Groningen', 'stato' => 'Olanda'],
        ['nome' => 'Heerenveen', 'stato' => 'Olanda'],
        ['nome' => 'Heracles Almelo', 'stato' => 'Olanda'],
        ['nome' => 'Fortuna Sittard', 'stato' => 'Olanda'],
        ['nome' => 'Cambuur', 'stato' => 'Olanda'],
        ['nome' => 'Sparta Rotterdam', 'stato' => 'Olanda'],
        ['nome' => 'Waalwijk', 'stato' => 'Olanda'],
        ['nome' => 'Emmen', 'stato' => 'Olanda'],
        ['nome' => 'Excelsior', 'stato' => 'Olanda'],
        ['nome' => 'Heracles Almelo', 'stato' => 'Olanda'],
        ['nome' => 'Go Ahead Eagles', 'stato' => 'Olanda'],
        ['nome' => 'Zwolle', 'stato' => 'Olanda'],
        ['nome' => 'Telstar', 'stato' => 'Olanda'],
        ['nome' => 'Dordrecht', 'stato' => 'Olanda'],
    ];

    private $squadre_competizioni = [
        // Serie A
        ['squadra_nome' => 'Juventus', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Milan', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Inter', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Roma', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Lazio', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Napoli', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Atalanta', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Torino', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Fiorentina', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie A', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Genoa', 'squadra_stato' => 'Italia',  'competizione_nome' =>  'Serie A', 'competizione_stato' => 'Italia'],

        // Serie B
        ['squadra_nome' => 'Parma', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie B', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Cagliari', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie B', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Brescia', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie B', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Reggina', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie B', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Perugia', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie B', 'competizione_stato' => 'Italia'],
        ['squadra_nome' => 'Cittadella', 'squadra_stato' => 'Italia', 'competizione_nome' => 'Serie B', 'competizione_stato' => 'Italia'],

        // UEFA Champions League
        ['squadra_nome' => 'Genoa', 'squadra_stato' => 'Italia',  'competizione_nome' =>  'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Juventus', 'squadra_stato' => 'Italia', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Milan', 'squadra_stato' => 'Italia', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Inter', 'squadra_stato' => 'Italia', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Porto', 'squadra_stato' => 'Portogallo',  'competizione_nome' =>  'UEFA Champions League',  'competizione_stato' =>  'Europa'],
        ['squadra_nome' => 'Benfica',  'squadra_stato' =>  'Portogallo',  'competizione_nome' =>  'UEFA Champions League',  'competizione_stato' =>  'Europa'],
        ['squadra_nome' => 'Bayern Monaco', 'squadra_stato' => 'Germania', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Barcelona', 'squadra_stato' => 'Spagna', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Real Madrid', 'squadra_stato' => 'Spagna', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Manchester City', 'squadra_stato' => 'Inghilterra', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Chelsea', 'squadra_stato' => 'Inghilterra', 'competizione_nome' => 'UEFA Champions League', 'competizione_stato' => 'Europa'],

        // UEFA Europa League
        ['squadra_nome' => 'Roma', 'squadra_stato' => 'Italia', 'competizione_nome' => 'UEFA Europa League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Tottenham Hotspur', 'squadra_stato' => 'Inghilterra', 'competizione_nome' => 'UEFA Europa League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Villarreal', 'squadra_stato' => 'Spagna', 'competizione_nome' => 'UEFA Europa League', 'competizione_stato' => 'Europa'],
        ['squadra_nome' => 'Wolverhampton', 'squadra_stato' => 'Inghilterra', 'competizione_nome' => 'UEFA Europa League', 'competizione_stato' => 'Europa'],

        // Aggiungi altre competizioni o squadre qui
        // E.g., Copa Libertadores, Serie C, altre squadre per altre competizioni.
    ];


    public function __construct($db)
    {
        $this->db = $db;
        $this->crea_utenti();  // Crea la tabella utenti
        $this->crea_stati(); // Crea la tabella stati
        $this->crea_competizioni(); // Crea la tabella compitizioni
        $this->crea_squadre(); // Crea la tabella squadre
        $this->crea_squadre_competizioni(); // Crea la tabella squadre_competizioni

        $this->inserisci_stati(); // Inserisce gli stati nella tabella stati
        $this->inserisci_competizioni(); // Inserisce le competizioni nella tabella competizioni
        $this->inserisci_squadre(); // Inserisce le squadre nella tabella squadre
        $this->inserisci_squadre_competizioni(); // Inserisce le squadre_competizioni nella tabella squadre_competizioni
    }

    /* CREAZIONE TABELLE */
    public function crea_utenti()
    {
        $this->db->createTable('utenti', '
        username VARCHAR(50) NOT NULL PRIMARY KEY, 
        password VARCHAR(255) NOT NULL, 
        email VARCHAR(100) NOT NULL,
        params JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');
    }

    public function crea_stati()
    {
        $this->db->createTable('stati', '
        id INT NOT NULL,  -- ID auto-incrementante
        nome VARCHAR(100) PRIMARY KEY,  -- Il nome sarà la chiave primaria
        descrizione TEXT,
        params JSON,
        parent_id VARCHAR(100) DEFAULT NULL,  -- Il parent sarà un nome (di un continente o del mondo)
        FOREIGN KEY (parent_id) REFERENCES stati(nome) ON DELETE SET NULL
        ');
    }

    public function crea_competizioni()
    {
        $this->db->createTable('competizioni', '
        id INT NOT NULL,  -- ID auto-incrementante
        nome VARCHAR(100) NOT NULL,
        stato VARCHAR(100) NOT NULL,  -- stato ora è il nome dello stato
        descrizione TEXT,
        params JSON,
        PRIMARY KEY (nome, stato),  -- La chiave primaria è la combinazione di nome e stato
        FOREIGN KEY (stato) REFERENCES stati(nome) ON DELETE CASCADE
        ');
    }

    public function crea_squadre()
    {
        $this->db->createTable('squadre', '
        id INT NOT NULL,  -- ID auto-incrementante
        nome VARCHAR(100) NOT NULL,
        stato VARCHAR(100) NOT NULL,  -- stato ora è il nome dello stato
        descrizione TEXT,
        params JSON,
        PRIMARY KEY (nome, stato),  -- La chiave primaria è la combinazione di nome e stato
        FOREIGN KEY (stato) REFERENCES stati(nome) ON DELETE CASCADE
        ');
    }

    public function crea_squadre_competizioni()
    {
        $this->db->createTable('squadre_competizioni', '
        squadra_nome VARCHAR(100) NOT NULL,
        squadra_stato VARCHAR(100) NOT NULL,  -- stato della squadra
        competizione_nome VARCHAR(100) NOT NULL,
        competizione_stato VARCHAR(100) NOT NULL,  -- stato della competizione
        PRIMARY KEY (squadra_nome, squadra_stato, competizione_nome, competizione_stato),  -- La chiave primaria è la combinazione di tutti questi campi
        FOREIGN KEY (squadra_nome, squadra_stato) REFERENCES squadre(nome, stato) ON DELETE CASCADE,
        FOREIGN KEY (competizione_nome, competizione_stato) REFERENCES competizioni(nome, stato) ON DELETE CASCADE
        ');
    }

    /* INSERIMENTO DATI */
    public function inserisci_stati()
    {
        // 1) Mondo
        $this->db->insert(
            "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
            [1, 'Mondo', null]
        );

        // 2) Continenti: ID 2–7, parent_id = 1
        foreach ($this->continenti as $i => $continent) {
            $id = $i + 2;
            $this->db->insert(
                "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
                [$id, $continent, 'Mondo']
            );
        }

        // 3) Stati per ogni continente
        $this->inserisciStatiFigli($this->stati_europa, 'Europa', 100);
        $this->inserisciStatiFigli($this->stati_america_sud, 'America Sud', 200);
        $this->inserisciStatiFigli($this->stati_america_nord, 'America Nord', 300);
        $this->inserisciStatiFigli($this->stati_africa, 'Africa', 400);
        $this->inserisciStatiFigli($this->stati_asia, 'Asia', 500);
        $this->inserisciStatiFigli($this->stati_oceania, 'Oceania', 600);

        // 4) Personalizzato
        $this->db->insert(
            "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
            [999999, 'Personalizzato', null]
        );
    }

    public function inserisci_competizioni()
    {
        $id = 1; // ID auto-incrementante per le competizioni
        foreach ($this->competizioni as $competizione) {
            $this->db->insert(
                "INSERT IGNORE INTO competizioni (id, nome, stato) VALUES (?, ?, ?)",
                [$id++, $competizione['nome'], $competizione['stato']]
            );
        }
    }

    public function inserisci_squadre()
    {
        $id = 1; // ID auto-incrementante per le squadre
        foreach ($this->squadre as $s) {
            $this->db->insert(
                "INSERT IGNORE INTO squadre (id, nome, stato) VALUES (?, ?, ?)",
                [$id++, $s['nome'], $s['stato']]
            );
        }
    }

    public function inserisci_squadre_competizioni()
    {
        foreach ($this->squadre_competizioni as $squadra_competizione) {
            $this->db->insert(
                "INSERT IGNORE INTO squadre_competizioni (squadra_nome, squadra_stato, competizione_nome, competizione_stato) VALUES (?, ?, ?, ?)",
                [
                    $squadra_competizione['squadra_nome'],
                    $squadra_competizione['squadra_stato'],
                    $squadra_competizione['competizione_nome'],
                    $squadra_competizione['competizione_stato']
                ]
            );
        }
    }

    /* UTILITA' */
    private function inserisciStatiFigli(array $stati, string $parentId, int $startId)
    {
        foreach ($stati as $index => $nome) {
            $this->db->insert(
                "INSERT IGNORE INTO stati (id, nome, parent_id) VALUES (?, ?, ?)",
                [$startId + $index, $nome, $parentId]
            );
        }
    }
}
