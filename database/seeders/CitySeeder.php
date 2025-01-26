<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $CountriesCities = [
            // "Afghanistan" => [
            //     "Kabul",
            //     "Kandahar",
            //     "Herat",
            //     "Mazar-i-Sharif",
            //     "Jalalabad",
            //     "Kunduz",
            //     "Ghazni",
            //     "Balkh",
            //     "Pul-e-Khumri",
            //     "Sar-e Pol"
            // ],
            // "Aland Islands" => [
            //     "Mariehamn",
            //     "Jomala",
            //     "Finström",
            //     "Lemland",
            //     "Saltvik",
            //     "Sund",
            //     "Hammarland",
            //     "Kumlinge",
            //     "Brändö",
            //     "Eckerö"
            // ],
            // "Albania" => [
            //     "Tirana",
            //     "Durrës",
            //     "Vlorë",
            //     "Elbasan",
            //     "Shkodër",
            //     "Fier",
            //     "Kamëz",
            //     "Korçë",
            //     "Lushnjë",
            //     "Pogradec"
            // ],
            // "Algeria" => [
            //     "Algiers",
            //     "Oran",
            //     "Constantine",
            //     "Batna",
            //     "Annaba",
            //     "Blida",
            //     "Setif",
            //     "Sidi Bel Abbès",
            //     "Biskra",
            //     "Tébessa"
            // ],
            // "American Samoa" => [
            //     "Pago Pago",
            //     "Tafuna",
            //     "Leone",
            //     "Faleniu",
            //     "Aūa",
            //     "Mapusagafou",
            //     "Vailoatai",
            //     "Faga'itua",
            //     "Vaitogi",
            //     "Malaeimi"
            // ],
            // "Andorra" => [
            //     "Andorra la Vella",
            //     "Escaldes-Engordany",
            //     "Encamp",
            //     "Sant Julià de Lòria",
            //     "La Massana",
            //     "Ordino",
            //     "Canillo"
            // ],
            // "Angola" => [
            //     "Luanda",
            //     "Huambo",
            //     "Lobito",
            //     "Benguela",
            //     "Kuito",
            //     "Malanje",
            //     "Namibe",
            //     "Soyo",
            //     "Cabinda",
            //     "Uíge"
            // ],
            // "Anguilla" => [
            //     "The Valley",
            //     "South Hill",
            //     "George Hill",
            //     "Stoney Ground",
            //     "North Side",
            //     "Sandy Ground",
            //     "Island Harbour",
            //     "West End Village",
            //     "Blowing Point Village",
            //     "East End Village"
            // ],
            // "Antigua and Barbuda" => [
            //     "St. John's",
            //     "All Saints",
            //     "Liberta",
            //     "Potter's Village",
            //     "Bolands",
            //     "Swetes",
            //     "Seaview Farm",
            //     "Piggotts",
            //     "Parham",
            //     "Willikies"
            // ],
            // "Argentina" => [
            //     "Buenos Aires",
            //     "Córdoba",
            //     "Rosario",
            //     "Mendoza",
            //     "La Plata",
            //     "San Miguel de Tucumán",
            //     "Mar del Plata",
            //     "Salta",
            //     "Santa Fe",
            //     "San Juan"
            // ],
            // "Armenia" => [
            //     "Yerevan",
            //     "Gyumri",
            //     "Vanadzor",
            //     "Vagharshapat",
            //     "Hrazdan",
            //     "Abovyan",
            //     "Kapan",
            //     "Armavir",
            //     "Ijevan",
            //     "Gavar"
            // ],
            // "Aruba" => [
            //     "Oranjestad",
            //     "Noord",
            //     "Santa Cruz",
            //     "Paradera",
            //     "Savaneta",
            //     "San Nicolas",
            //     "Pos Chiquito",
            //     "Sint Nicolaas",
            //     "Tanki Leendert",
            //     "Madiki"
            // ],
            // "Australia" => [
            //     "Sydney",
            //     "Melbourne",
            //     "Brisbane",
            //     "Perth",
            //     "Adelaide",
            //     "Gold Coast",
            //     "Canberra",
            //     "Newcastle",
            //     "Wollongong",
            //     "Logan City"
            // ],
            // "Austria" => [
            //     "Vienna",
            //     "Graz",
            //     "Linz",
            //     "Salzburg",
            //     "Innsbruck",
            //     "Klagenfurt",
            //     "Wels",
            //     "Steyr",
            //     "Bregenz",
            //     "Wolfsberg"
            // ],
            // "Azerbaijan" => [
            //     "Baku",
            //     "Ganja",
            //     "Sumqayit",
            //     "Mingachevir",
            //     "Khirdalan",
            //     "Shirvan",
            //     "Nakhchivan",
            //     "Shaki",
            //     "Yevlakh",
            //     "Barda"
            // ],
            // "Bahamas" => [
            //     "Nassau",
            //     "Freeport",
            //     "Lucaya",
            //     "West End",
            //     "Coopers Town",
            //     "Marsh Harbour",
            //     "High Rock",
            //     "Andros Town",
            //     "Clarence Town",
            //     "Dunmore Town"
            // ],
            // "Bahrain" => [
            //     "Manama",
            //     "Riffa",
            //     "Muharraq",
            //     "Isa Town",
            //     "Sitrah",
            //     "Budaiya",
            //     "Jidhafs",
            //     "Al-Malikiyah",
            //     "Adliya",
            //     "Juffair"
            // ],
            // "Bangladesh" => [
            //     "Dhaka",
            //     "Chittagong",
            //     "Khulna",
            //     "Rajshahi",
            //     "Comilla",
            //     "Tongi",
            //     "Jessore",
            //     "Narayanganj",
            //     "Sylhet",
            //     "Mymensingh"
            // ],
            // "Barbados" => [
            //     "Bridgetown",
            //     "Speightstown",
            //     "Oistins",
            //     "Holetown",
            //     "Crab Hill"
            // ],
            // "Belarus" => [
            //     "Minsk",
            //     "Gomel",
            //     "Mogilev",
            //     "Vitebsk",
            //     "Brest"
            // ],
            // "Belgium" => [
            //     "Brussels",
            //     "Antwerp",
            //     "Ghent",
            //     "Charleroi",
            //     "Liege"
            // ],
            // "Belize" => [
            //     "Belize City",
            //     "San Ignacio",
            //     "Orange Walk",
            //     "Dangriga",
            //     "Corozal"
            // ],
            // "Benin" => [
            //     "Cotonou",
            //     "Porto-Novo",
            //     "Parakou",
            //     "Djougou",
            //     "Bohicon"
            // ],
            // "Bermuda" => [
            //     "Hamilton",
            //     "St. George's",
            //     "Somerset Village",
            //     "Bailey's Bay",
            //     "Flatts Village"
            // ],
            // "Bhutan" => [
            //     "Thimphu",
            //     "Phuntsholing",
            //     "Punakha",
            //     "Wangdue Phodrang",
            //     "Paro"
            // ],
            // "Bolivia, Plurinational State of" => [
            //     "La Paz",
            //     "Sucre",
            //     "Santa Cruz de la Sierra",
            //     "El Alto",
            //     "Cochabamba"
            // ],
            // "Bonaire, Sint Eustatius and Saba" => [
            //     "Kralendijk",
            //     "Oranjestad",
            //     "The Bottom"
            // ],
            // "Bosnia and Herzegovina" => [
            //     "Sarajevo",
            //     "Banja Luka",
            //     "Tuzla",
            //     "Mostar",
            //     "Bihac"
            // ],
            // "Botswana" => [
            //     "Gaborone",
            //     "Francistown",
            //     "Molepolole",
            //     "Serowe",
            //     "Selibe Phikwe"
            // ],
            // "Brazil" => [
            //     "São Paulo",
            //     "Rio de Janeiro",
            //     "Brasília",
            //     "Salvador",
            //     "Fortaleza"
            // ],
            // "British Indian Ocean Territory" => [
            //     "Diego Garcia"
            // ],
            // "Brunei Darussalam" => [
            //     "Bandar Seri Begawan",
            //     "Kuala Belait",
            //     "Seria",
            //     "Tutong"
            // ],
            // "Bulgaria" => [
            //     "Sofia",
            //     "Plovdiv",
            //     "Varna",
            //     "Burgas",
            //     "Ruse"
            // ],
            // "Burkina Faso" => [
            //     "Ouagadougou",
            //     "Bobo-Dioulasso",
            //     "Koudougou",
            //     "Ouahigouya",
            //     "Banfora"
            // ],
            // "Burundi" => [
            //     "Bujumbura",
            //     "Gitega",
            //     "Ngozi",
            //     "Ruyigi",
            //     "Muyinga"
            // ],
            // "Cambodia" => [
            //     "Phnom Penh",
            //     "Siem Reap",
            //     "Battambang",
            //     "Sihanoukville",
            //     "Kampot"
            // ],
            // "Christmas Island" => [
            //     "Flying Fish Cove"
            // ],
            // "Cocos (Keeling) Islands" => [
            //     "West Island",
            //     "Bantam Village",
            //     "Home Island"
            // ],
            // "Colombia" => [
            //     "Bogotá",
            //     "Medellín",
            //     "Cali",
            //     "Barranquilla",
            //     "Cartagena"
            // ],
            // "Comoros" => [
            //     "Moroni",
            //     "Mutsamudu",
            //     "Fomboni"
            // ],
            // "Cook Islands" => [
            //     "Avarua",
            //     "Arutanga",
            //     "Oneroa",
            //     "Rakahanga",
            //     "Temaiku"
            // ],
            // "Costa Rica" => [
            //     "San José",
            //     "Limon",
            //     "Alajuela",
            //     "Heredia",
            //     "Cartago"
            // ],
            // "Côte d'Ivoire" => [
            //     "Abidjan",
            //     "Bouaké",
            //     "Daloa",
            //     "Yamoussoukro",
            //     "Korhogo"
            // ],
            // "Croatia" => [
            //     "Zagreb",
            //     "Split",
            //     "Rijeka",
            //     "Osijek",
            //     "Pula"
            // ],
            // "Cuba" => [
            //     "Havana",
            //     "Santiago de Cuba",
            //     "Camagüey",
            //     "Holguín",
            //     "Guantánamo"
            // ],
            // "Curaçao" => [
            //     "Willemstad",
            //     "Sint Michiel Liber",
            //     "Soto",
            //     "Barber",
            //     "Sabana Westpunt"
            // ],
            // "Czech Republic" => [
            //     "Prague",
            //     "Brno",
            //     "Ostrava",
            //     "Pilsen",
            //     "Olomouc"
            // ],
            // "Denmark" => [
            //     "Copenhagen",
            //     "Aarhus",
            //     "Odense",
            //     "Aalborg",
            //     "Esbjerg"
            // ],
            // "Djibouti" => [
            //     "Djibouti",
            //     "Tadjoura",
            //     "Ali Sabieh",
            //     "Obock",
            //     "Dikhil"
            // ],
            // "Dominica" => [
            //     "Roseau",
            //     "Portsmouth",
            //     "Marigot",
            //     "Mahaut",
            //     "Wesley"
            // ],
            // "Dominican Republic" => [
            //     "Santo Domingo",
            //     "Santiago",
            //     "San Pedro de Macorís",
            //     "La Romana",
            //     "San Francisco de Macorís"
            // ],
            // "Ecuador" => [
            //     "Quito",
            //     "Guayaquil",
            //     "Cuenca",
            //     "Santo Domingo",
            //     "Machala"
            // ],
            // "Egypt" => [
            //     "Cairo",
            //     "Alexandria",
            //     "Giza",
            //     "Shubra El-Kheima",
            //     "Port Said"
            // ],
            // "El Salvador" => [
            //     "San Salvador",
            //     "Santa Ana",
            //     "Soyapango",
            //     "San Miguel",
            //     "Mejicanos"
            // ],
            // "Equatorial Guinea" => [
            //     "Malabo",
            //     "Bata",
            //     "Ebebiyín",
            //     "Aconibe",
            //     "Anisoc"
            // ],
            // "Eritrea" => [
            //     "Asmara",
            //     "Keren",
            //     "Massawa",
            //     "Assab",
            //     "Mendefera"
            // ],
            // "Estonia" => [
            //     "Tallinn",
            //     "Tartu",
            //     "Narva",
            //     "Kohtla-Järve",
            //     "Pärnu"
            // ],
            // "Ethiopia" => [
            //     "Addis Ababa",
            //     "Dire Dawa",
            //     "Nazret",
            //     "Gondar",
            //     "Awasa"
            // ],
            // "Fiji" => [
            //     "Suva",
            //     "Lautoka",
            //     "Nadi",
            //     "Labasa",
            //     "Levuka"
            // ],
            // "Finland" => [
            //     "Helsinki",
            //     "Espoo",
            //     "Tampere",
            //     "Vantaa",
            //     "Oulu"
            // ],
            // "France" => [
            //     "Paris",
            //     "Marseille",
            //     "Lyon",
            //     "Toulouse",
            //     "Nice"
            // ],
            // "French Polynesia" => [
            //     "Papeete",
            //     "Faaa",
            //     "Punaauia",
            //     "Pirae",
            //     "Mahina"
            // ],
            // "Gabon" => [
            //     "Libreville",
            //     "Port-Gentil",
            //     "Franceville",
            //     "Oyem",
            //     "Mouila"
            // ],
            // "Gambia" => [
            //     "Banjul",
            //     "Serekunda",
            //     "Brikama",
            //     "Bakau",
            //     "Farafenni"
            // ],
            // "Georgia" => [
            //     "Tbilisi",
            //     "Kutaisi",
            //     "Batumi",
            //     "Rustavi",
            //     "Zugdidi"
            // ],
            // "Germany" => [
            //     "Berlin",
            //     "Hamburg",
            //     "Munich",
            //     "Cologne",
            //     "Frankfurt"
            // ],
            // "Ghana" => [
            //     "Accra",
            //     "Kumasi",
            //     "Tamale",
            //     "Takoradi",
            //     "Cape Coast"
            // ],
            // "Gibraltar" => [
            //     "Gibraltar"
            // ],
            // "Greece" => [
            //     "Athens",
            //     "Thessaloniki",
            //     "Patras",
            //     "Heraklion",
            //     "Larissa",
            //     "Volos",
            //     "Ioannina",
            //     "Kavala",
            //     "Chania",
            //     "Rhodes"
            // ],
            // "Greenland" => [
            //     "Nuuk",
            //     "Ilulissat",
            //     "Qaqortoq",
            //     "Sisimiut",
            //     "Maniitsoq",
            //     "Narsaq",
            //     "Tasiilaq",
            //     "Uummannaq",
            //     "Paamiut",
            //     "Kangerlussuaq"
            // ],
            // "Grenada" => [
            //     "St. George's",
            //     "Gouyave",
            //     "Victoria",
            //     "Sauteurs",
            //     "Hillsborough"
            // ],
            // "Guam" => [
            //     "Hagåtña",
            //     "Tamuning",
            //     "Yigo",
            //     "Dededo",
            //     "Barrigada",
            //     "Mangilao"
            // ],
            // "Guatemala" => [
            //     "Guatemala City",
            //     "Mixco",
            //     "Villa Nueva",
            //     "Quetzaltenango",
            //     "San Juan Sacatepéquez",
            //     "Escuintla",
            //     "Chinautla"
            // ],
            // "Guernsey" => [
            //     "Saint Peter Port",
            //     "St. Sampson",
            //     "Vale",
            //     "Torteval",
            //     "Castel",
            //     "St. Martin"
            // ],
            // "Guinea" => [
            //     "Conakry",
            //     "Nzérékoré",
            //     "Kindia",
            //     "Kankan",
            //     "Gueckedou",
            //     "Boke",
            //     "Labé"
            // ],
            // "Guinea-Bissau" => [
            //     "Bissau",
            //     "Gabú",
            //     "Bafatá",
            //     "Canchungo",
            //     "Cacheu",
            //     "Farim",
            //     "Bolama"
            // ],
            // "Haiti" => [
            //     "Port-au-Prince",
            //     "Delmas",
            //     "Carrefour",
            //     "Cap-Haïtien",
            //     "Pétion-Ville"
            // ],
            // "Honduras" => [
            //     "Tegucigalpa",
            //     "San Pedro Sula",
            //     "Choloma",
            //     "La Ceiba",
            //     "El Progreso"
            // ],
            // "Hong Kong" => [
            //     "Hong Kong Island",
            //     "Kowloon",
            //     "New Territories",
            //     "Sha Tin",
            //     "Tsuen Wan"
            // ],
            // "Hungary" => [
            //     "Budapest",
            //     "Debrecen",
            //     "Szeged",
            //     "Miskolc",
            //     "Pécs"
            // ],
            // "Iceland" => [
            //     "Reykjavik",
            //     "Kópavogur",
            //     "Hafnarfjörður",
            //     "Akureyri",
            //     "Garðabær"
            // ],
            // "India" => [
            //     "Mumbai",
            //     "Delhi",
            //     "Bangalore",
            //     "Hyderabad",
            //     "Chennai"
            // ],
            // "Indonesia" => [
            //     "Jakarta",
            //     "Surabaya",
            //     "Bandung",
            //     "Medan",
            //     "Palembang"
            // ],
            // "Iran, Islamic Republic of" => [
            //     "Tehran",
            //     "Mashhad",
            //     "Isfahan",
            //     "Karaj",
            //     "Tabriz"
            // ],
            // "Iraq" => [
            //     "Baghdad",
            //     "Basra",
            //     "Mosul",
            //     "Erbil",
            //     "Kirkuk"
            // ],
            // "Ireland" => [
            //     "Dublin",
            //     "Cork",
            //     "Limerick",
            //     "Galway",
            //     "Waterford"
            // ],
            // "Isle of Man" => [
            //     "Douglas",
            //     "Peel",
            //     "Port Erin",
            //     "Castletown",
            //     "Ramsey"
            // ],
            // "Palestine" => [
            //     "Jerusalem",
            //     "Ramallah",
            //     "Nablus",
            //     "Bethlehem",
            //     "Hebron",
            //     "Jenin",
            //     "Jericho",
            //     "Tulkarm",
            //     "Qalqilya",
            //     "Gaza City",
            //     "Beit Jala"
            // ],
            // "Israel" => [
            //     "Tel Aviv",
            //     "Haifa",
            //     "Rishon LeZion",
            //     "Petah Tikva"
            // ],
            // "Italy" => [
            //     "Rome",
            //     "Milan",
            //     "Naples",
            //     "Turin",
            //     "Palermo"
            // ],
            // "Jamaica" => [
            //     "Kingston",
            //     "Montego Bay",
            //     "Spanish Town",
            //     "May Pen",
            //     "Mandeville"
            // ],
            // "Japan" => [
            //     "Tokyo",
            //     "Yokohama",
            //     "Osaka",
            //     "Nagoya",
            //     "Sapporo"
            // ],
            // "Jersey" => [
            //     "Saint Helier",
            //     "Saint Aubin",
            //     "Gorey",
            //     "St. Lawrence",
            //     "St. Clement"
            // ],
            // "Jordan" => [
            //     "Amman",
            //     "Zarqa",
            //     "Irbid",
            //     "Aqaba",
            //     "Madaba"
            // ],
            // "Kazakhstan" => [
            //     "Almaty",
            //     "Nur-Sultan",
            //     "Karaganda",
            //     "Shymkent",
            //     "Taraz"
            // ],
            // "Kenya" => [
            //     "Nairobi",
            //     "Mombasa",
            //     "Kisumu",
            //     "Nakuru",
            //     "Eldoret"
            // ],
            // "Kiribati" => [
            //     "South Tarawa",
            //     "Betio",
            //     "Bikenibeu",
            //     "Teaoraereke",
            //     "Tabwakea"
            // ],
            // "Korea, Democratic People's Republic of" => [
            //     "Pyongyang",
            //     "Hamhung",
            //     "Chongjin",
            //     "Nampo",
            //     "Sariwon"
            // ],
            // "Kuwait" => [
            //     "Kuwait City",
            //     "Al Ahmadi",
            //     "Hawalli",
            //     "Farwaniya",
            //     "Jahra"
            // ],
            // "Kyrgyzstan" => [
            //     "Bishkek",
            //     "Osh",
            //     "Jalal-Abad",
            //     "Kara-Balta",
            //     "Kyzyl-Kiya"
            // ],
            // "Lao People's Democratic Republic" => [
            //     "Vientiane",
            //     "Pakse",
            //     "Savannakhet",
            //     "Luang Prabang",
            //     "Thakhek"
            // ],
            // "Latvia" => [
            //     "Riga",
            //     "Daugavpils",
            //     "Liepaja",
            //     "Jelgava",
            //     "Jurmala"
            // ],
            // "Lebanon" => [
            //     "Beirut",
            //     "Tripoli",
            //     "Sidon",
            //     "Tyre",
            //     "Jounieh"
            // ],
            // "Lesotho" => [
            //     "Maseru",
            //     "Teyateyaneng",
            //     "Mafeteng",
            //     "Hlotse",
            //     "Mohale's Hoek"
            // ],
            // "Liberia" => [
            //     "Monrovia",
            //     "Gbarnga",
            //     "Bensonville",
            //     "Harper",
            //     "Zwedru"
            // ],
            // "Libya" => [
            //     "Tripoli",
            //     "Benghazi",
            //     "Misrata",
            //     "Zawiya",
            //     "Sabha"
            // ],
            // "Liechtenstein" => [
            //     "Vaduz",
            //     "Schaan",
            //     "Triesen",
            //     "Balzers",
            //     "Eschen"
            // ],
            // "Lithuania" => [
            //     "Vilnius",
            //     "Kaunas",
            //     "Klaipeda",
            //     "Siauliai",
            //     "Panevezys"
            // ],
            // "Luxembourg" => [
            //     "Luxembourg City",
            //     "Esch-sur-Alzette",
            //     "Dudelange",
            //     "Schifflange",
            //     "Bettembourg"
            // ],
            // "Macao" => [
            //     "Macau",
            //     "Taipa",
            //     "Cotai",
            //     "Coloane",
            //     "Hac Sa"
            // ],
            // "Madagascar" => [
            //     "Antananarivo",
            //     "Toamasina",
            //     "Antsirabe",
            //     "Fianarantsoa",
            //     "Mahajanga"
            // ],
            // "Malawi" => [
            //     "Lilongwe",
            //     "Blantyre",
            //     "Mzuzu",
            //     "Zomba",
            //     "Kasungu"
            // ],
            // "Malaysia" => [
            //     "Kuala Lumpur",
            //     "George Town",
            //     "Johor Bahru",
            //     "Ipoh",
            //     "Shah Alam"
            // ],
            // "Maldives" => [
            //     "Malé",
            //     "Hithadhoo",
            //     "Kulhudhuffushi",
            //     "Thinadhoo",
            //     "Naifaru"
            // ],
            // "Mali" => [
            //     "Bamako",
            //     "Sikasso",
            //     "Mopti",
            //     "Koutiala",
            //     "Gao"
            // ],
            // "Malta" => [
            //     "Valletta",
            //     "Birkirkara",
            //     "Mosta",
            //     "Qormi",
            //     "Zabbar"
            // ],
            // "Marshall Islands" => [
            //     "Majuro",
            //     "Ebeye",
            //     "Arno",
            //     "Wotje",
            //     "Namdrik"
            // ],
            // "Martinique" => [
            //     "Fort-de-France",
            //     "Le Lamentin",
            //     "Sainte-Marie",
            //     "Le Robert",
            //     "Ducos"
            // ],
            // "Mauritania" => [
            //     "Nouakchott",
            //     "Nouadhibou",
            //     "Kiffa",
            //     "Kaédi",
            //     "Rosso"
            // ],
            // "Mauritius" => [
            //     "Port Louis",
            //     "Beau Bassin-Rose Hill",
            //     "Vacoas-Phoenix",
            //     "Curepipe",
            //     "Quatre Bornes"
            // ],
            // "Mexico" => [
            //     "Mexico City",
            //     "Guadalajara",
            //     "Monterrey",
            //     "Puebla",
            //     "Tijuana"
            // ],
            // "Micronesia, Federated States of" => [
            //     "Palikir",
            //     "Weno",
            //     "Colonia",
            //     "Tofol",
            //     "Kolonia"
            // ],
            // "Moldova, Republic of" => [
            //     "Chisinau",
            //     "Balti",
            //     "Tiraspol",
            //     "Bender",
            //     "Ribnita"
            // ],
            // "Monaco" => [
            //     "Monaco"
            // ],
            // "Mongolia" => [
            //     "Ulaanbaatar",
            //     "Erdenet",
            //     "Darkhan",
            //     "Choibalsan",
            //     "Khovd",
            //     "Olgii"
            // ],
            // "Montenegro" => [
            //     "Podgorica",
            //     "Nikšić",
            //     "Pljevlja",
            //     "Herceg Novi",
            //     "Bar",
            //     "Budva"
            // ],
            // "Montserrat" => [
            //     "Plymouth",
            //     "Brades"
            // ],
            // "Morocco" => [
            //     "Rabat",
            //     "Casablanca",
            //     "Fes",
            //     "Marrakesh",
            //     "Tangier",
            //     "Agadir"
            // ],
            // "Mozambique" => [
            //     "Maputo",
            //     "Matola",
            //     "Beira",
            //     "Nampula",
            //     "Chimoio",
            //     "Nacala"
            // ],
            // "Myanmar" => [
            //     "Naypyidaw",
            //     "Yangon",
            //     "Mandalay",
            //     "Nay Pyi Taw",
            //     "Mawlamyine",
            //     "Bago"
            // ],
            // "Namibia" => [
            //     "Windhoek",
            //     "Rundu",
            //     "Walvis Bay",
            //     "Oshakati",
            //     "Swakopmund",
            //     "Katima Mulilo"
            // ],
            // "Nauru" => [
            //     "Yaren"
            // ],
            // "Nepal" => [
            //     "Kathmandu",
            //     "Pokhara",
            //     "Patan",
            //     "Biratnagar",
            //     "Bharatpur",
            //     "Birgunj"
            // ],
            // "Netherlands" => [
            //     "Amsterdam",
            //     "Rotterdam",
            //     "The Hague",
            //     "Utrecht",
            //     "Eindhoven",
            //     "Tilburg"
            // ],
            // "New Zealand" => [
            //     "Auckland",
            //     "Wellington",
            //     "Christchurch",
            //     "Hamilton",
            //     "Tauranga",
            //     "Napier"
            // ],
            // "Nicaragua" => [
            //     "Managua",
            //     "León",
            //     "Masaya",
            //     "Chinandega",
            //     "Matagalpa",
            //     "Estelí",
            //     "Granada",
            //     "Ciudad Sandino",
            //     "Jinotepe",
            //     "Juigalpa"
            // ],
            // "Niger" => [
            //     "Niamey",
            //     "Zinder",
            //     "Maradi",
            //     "Agadez",
            //     "Tahoua",
            //     "Dosso",
            //     "Diffa",
            //     "Arlit",
            //     "Birni-N'Konni",
            //     "Madaoua"
            // ],
            // "Nigeria" => [
            //     "Lagos",
            //     "Kano",
            //     "Ibadan",
            //     "Abuja",
            //     "Benin City",
            //     "Port Harcourt",
            //     "Jos",
            //     "Ilorin",
            //     "Kaduna",
            //     "Enugu"
            // ],
            // "Niue" => [
            //     "Alofi",
            //     "Avatele",
            //     "Hakupu",
            //     "Hikutavake",
            //     "Lakepa",
            //     "Makefu",
            //     "Mutalau",
            //     "Tamakautoga",
            //     "Tuapa",
            //     "Vaiea"
            // ],
            // "Norfolk Island" => [
            //     "Kingston",
            //     "Burnt Pine",
            //     "Cascade",
            //     "Anson Bay",
            //     "Bucks Point",
            //     "Middlegate",
            //     "Longridge",
            //     "Rocky Point",
            //     "Ball Bay",
            //     "Red Road"
            // ],
            // "Northern Mariana Islands" => [
            //     "Saipan",
            //     "Garapan",
            //     "San Jose Village",
            //     "Dandan",
            //     "San Roque",
            //     "Koblerville",
            //     "Chalan Kanoa",
            //     "San Vicente",
            //     "Capitol Hill",
            //     "Chalan Piao"
            // ],
            // "Norway" => [
            //     "Oslo",
            //     "Bergen",
            //     "Trondheim",
            //     "Stavanger",
            //     "Drammen",
            //     "Fredrikstad",
            //     "Porsgrunn",
            //     "Skien",
            //     "Kristiansand",
            //     "Tromsø"
            // ],
            "Oman" => [
                "Muscat",
                "Salalah",
                "Sohar",
                "Sur",
                "Nizwa",
                "Ibri",
                "Ibra",
                "Bahla",
                "Rustaq",
                "Al-Khabourah"
            ],
            // "Pakistan" => [
            //     "Karachi",
            //     "Lahore",
            //     "Faisalabad",
            //     "Rawalpindi",
            //     "Multan",
            //     "Gujranwala",
            //     "Hyderabad",
            //     "Peshawar",
            //     "Islamabad",
            //     "Quetta"
            // ],
            // "Palau" => [
            //     "Koror",
            //     "Airai",
            //     "Melekeok",
            //     "Ngaraard",
            //     "Ngarchelong",
            //     "Ngardmau",
            //     "Ngatpang",
            //     "Ngchesar",
            //     "Sonsorol",
            //     "Hatohobei"
            // ],

            // "Panama" => [
            //     "Panama City",
            //     "Colon",
            //     "David",
            //     "Santiago",
            //     "Chitre",
            //     "Las Tablas",
            //     "La Chorrera",
            //     "Penonome",
            //     "Aguadulce",
            //     "Bocas del Toro"
            // ],
            // "Papua New Guinea" => [
            //     "Port Moresby",
            //     "Lae",
            //     "Arawa",
            //     "Mount Hagen",
            //     "Popondetta",
            //     "Madang",
            //     "Kokopo",
            //     "Mendi",
            //     "Kimbe",
            //     "Goroka"
            // ],
            // "Paraguay" => [
            //     "Asuncion",
            //     "Ciudad del Este",
            //     "San Lorenzo",
            //     "Capiata",
            //     "Lambare",
            //     "Fernando de la Mora",
            //     "Limpio",
            //     "Encarnacion",
            //     "Nemby",
            //     "Villa Elisa"
            // ],
            // "Peru" => [
            //     "Lima",
            //     "Arequipa",
            //     "Trujillo",
            //     "Chiclayo",
            //     "Piura",
            //     "Iquitos",
            //     "Cusco",
            //     "Huancayo",
            //     "Tacna",
            //     "Chimbote"
            // ],
            // "Philippines" => [
            //     "Manila",
            //     "Quezon City",
            //     "Caloocan",
            //     "Davao City",
            //     "Cebu City",
            //     "Zamboanga City",
            //     "Taguig",
            //     "Pasig",
            //     "Antipolo",
            //     "Valenzuela"
            // ],
            // "Poland" => [
            //     "Warsaw",
            //     "Kraków",
            //     "Łódź",
            //     "Wrocław",
            //     "Poznań",
            //     "Gdańsk",
            //     "Szczecin",
            //     "Bydgoszcz",
            //     "Lublin",
            //     "Białystok",
            //     "Katowice",
            //     "Gdynia",
            //     "Częstochowa",
            //     "Radom",
            //     "Sosnowiec",
            //     "Toruń",
            //     "Kielce",
            //     "Rzeszów",
            //     "Gliwice",
            //     "Zabrze"
            // ],
            // "Portugal" => [
            //     "Lisbon",
            //     "Porto",
            //     "Amadora",
            //     "Braga",
            //     "Setúbal",
            //     "Coimbra",
            //     "Queluz",
            //     "Funchal",
            //     "Cacém",
            //     "Vila Nova de Gaia",
            //     "Loures",
            //     "Rio de Mouro",
            //     "Odivelas",
            //     "Aveiro",
            //     "Barreiro",
            //     "Póvoa de Varzim",
            //     "Faro",
            //     "Almada",
            //     "Santarém",
            //     "Castelo Branco"
            // ],
            // "Qatar" => [
            //     "Doha",
            //     "Al Wakrah",
            //     "Al Khor",
            //     "Al Rayyan",
            //     "Umm Salal"
            // ],
            // "Saudi Arabia" => [
            //     "Riyadh",
            //     "Jeddah",
            //     "Mecca",
            //     "Medina",
            //     "Dammam",
            //     "Ta'if",
            //     "Tabuk",
            //     "Al-Kharj",
            //     "Buraidah",
            //     "Khobar"
            // ],
            // "South Korea" => [
            //     "Seoul",
            //     "Busan",
            //     "Incheon",
            //     "Daegu",
            //     "Daejeon",
            //     "Gwangju",
            //     "Ulsan",
            //     "Suwon",
            //     "Changwon",
            //     "Sejong"
            // ],
            // "South Sudan" => [
            //     "Juba",
            //     "Bor",
            //     "Malakal",
            //     "Wau",
            //     "Yei",
            //     "Aweil",
            //     "Kuajok",
            //     "Rumbek",
            //     "Bentiu",
            //     "Torit"
            // ],
            // "Sudan" => [
            //     "Khartoum",
            //     "Omdurman",
            //     "Nyala",
            //     "Port Sudan",
            //     "Kassala",
            //     "El Obeid",
            //     "Wad Madani",
            //     "El Fasher",
            //     "Ad-Damazin",
            //     "Geneina"
            // ],
            // "Syrian Arab Republic" => [
            //     "Damascus",
            //     "Aleppo",
            //     "Homs",
            //     "Hama",
            //     "Latakia",
            //     "Deir ez-Zor",
            //     "Al-Hasakah",
            //     "Raqqa",
            //     "Idlib",
            //     "Daraa"
            // ],
            // "Tunisia" => [
            //     "Tunis",
            //     "Sfax",
            //     "Sousse",
            //     "Ettadhamen",
            //     "Kairouan",
            //     "Gabès",
            //     "Bizerte",
            //     "Aryanah",
            //     "Gafsa",
            //     "Zarzis"
            // ],
            // "Turkey" => [
            //     "Istanbul",
            //     "Ankara",
            //     "Izmir",
            //     "Bursa",
            //     "Adana",
            //     "Gaziantep",
            //     "Konya",
            //     "Antalya",
            //     "Kayseri",
            //     "Mersin"
            // ],
            // "Uganda" => [
            //     "Kampala",
            //     "Gulu",
            //     "Lira",
            //     "Mbarara",
            //     "Jinja",
            //     "Bwizibwera",
            //     "Mbale",
            //     "Mityana",
            //     "Masaka",
            //     "Fort Portal"
            // ],
            // "Ukraine" => [
            //     "Kyiv",
            //     "Kharkiv",
            //     "Odesa",
            //     "Dnipro",
            //     "Donetsk",
            //     "Zaporizhzhia",
            //     "Lviv",
            //     "Kryvyi Rih",
            //     "Mykolaiv",
            //     "Mariupol"
            // ],
            // "United Arab Emirates" => [
            //     "Dubai",
            //     "Abu Dhabi",
            //     "Sharjah",
            //     "Al Ain",
            //     "Ajman",
            //     "Ras Al Khaimah",
            //     "Umm Al Quwain",
            //     "Fujairah",
            //     "Khor Fakkan",
            //     "Kalba"
            // ],
            // "United Kingdom" => [
            //     "London",
            //     "Manchester",
            //     "Birmingham",
            //     "Glasgow",
            //     "Liverpool",
            //     "Edinburgh",
            //     "Bristol",
            //     "Leeds",
            //     "Newcastle",
            //     "Sheffield"
            // ],
            // "United States" => [
            //     "New York City",
            //     "Los Angeles",
            //     "Chicago",
            //     "Houston",
            //     "Phoenix",
            //     "Philadelphia",
            //     "San Antonio",
            //     "San Diego",
            //     "Dallas",
            //     "San Jose"
            // ]
        ];
        $this->command->info('Adding Cities ... ');

        foreach ($CountriesCities as $countryName => $cities) {
            $country = Country::where('name', trim($countryName))->first();
            foreach ($cities as $cityName) {
                City::updateOrCreate([
                    'name' => [
                        'en' => $cityName,
                        'ar' => $cityName,
                    ],
                    'country_id' => $country->id
                ]);
            }
        }
        $this->command->info('Cities added successfully!');
    }
}
