using World.Content;

namespace World.Rooms
{
    public class RoomGenerator
    {
        private static string[] MOB_NAMES = {
            "Amelia",
            "Eva",
            "Milan",
            "Tessa",
            "Laura",
            "Luna",
            "Lotte",
            "Sara",
            "Lynn",
            "Fleur",
            "Sanne",
            "Evi",
            "Lieke",
            "Noa",
            "Sofie",
            "Saar",
            "Sofia",
            "Olivia",
        };

        private static string[] ITEM_NAMES = {
            "The amulet of the gods",
            "The amulet of the ancients",
            "The ring of honour",
            "Blessing of destiny",
            "The Crystal Veil",
            "Enigma Shard",
            "Whispers of Eternity",
            "Phantom Lantern",
            "Starforged Compass",
            "Scepter of Echoes",
            "Cloak of Twilight",
            "Astral Key",
            "Phoenix Quill",
            "Lunar Prism",
            "Runebound Crown",
            "Celestial Harmonica",
            "Abyssal Locket",
            "Serpent's Gaze",
            "Dreamweaver's Scepter",
            "Ethereal Chalice",
            "Emberheart Medallion",
            "Enchanted Cipher",
            "Veilstorm Amalgam",
            "Oathbreaker's Tear",
            "Wraithfire Talisman",
            "Runeblade of Frostfall",
            "Maelstrom Pendant",
            "Chrono-Ward Bangle",
            "Essence of the Void",
        };

        private static string[] OCCURANCE_NAMES = {
            "Chamber of Celestial Whispers",
            "Ethereal Nexus",
            "Hall of Enigmatic Mirrors",
            "Realm of Forgotten Tomorrows",
            "Temple of Eternal Echoes",
            "Sorcerer's Sanctum",
            "Cavern of Luminous Shadows",
            "Arcane Observatory",
            "Chalice Chamber",
            "Labyrinth of Timeless Dreams",
            "Gallery of Shifting Realms",
            "Crypt of Astral Serenity",
            "Chamber of the Cosmic Weaver",
            "Oracle's Nexus",
            "Sanctuary of Whispering Winds",
            "Enchanted Alcove",
            "Hall of Illusionary Echoes",
            "Mystic Arcanum",
            "Celestial Repository",
            "The Eternal Forge",
            "Spectral Observatory",
            "Dreamer's Sanctuary",
            "Vault of Ethereal Artifacts",
            "Lunar Enclave",
            "Shrouded Chamber of Secrets",
            "Empyrean Chamber",
            "Phantom Halls",
            "Netherrealm Antechamber",
            "The Sublime Vestibule"
        };

        private static string[] COMBAT_NAMES = {
            "Arena of Fading Shadows",
            "Battlefield of Blazing Elements",
            "Coliseum of Eternal Strife",
            "Doomed Battleground",
            "Chamber of Roaring Thunder",
            "Infernal Crucible",
            "Mystic Gauntlet",
            "Purgatory's Arena",
            "Labyrinth of Peril",
            "Thundering Coliseum",
            "Cataclysmic Pit",
            "Bloodied Spire",
            "Eclipse Arena",
            "Raging Inferno Pit",
            "Tempest Citadel",
            "Forsaken Battlement",
            "Ruins of the Damned",
            "Frostbite Coliseum",
            "Crimson Warzone",
            "Dread Citadel",
            "Searing Crucible",
            "Abyssal Abyss",
            "Pandemonium Arena",
            "Vortex Battleground",
            "Ebon Ramparts",
            "Necrotic Arena",
            "Tempest Keep",
            "Apocalyptic Coliseum",
            "The Void's Crucible"
        };

        private static Random rnd = new Random();

        public static List<ILocation> GenerateRooms(int amount = 10)
        {
            List<ILocation> rooms = new List<ILocation>();
            for (int i = 0; i < amount; i++)
            {
                rooms.Add(generateRoom<IContent>(i));
            }
            return rooms;
        }

        private static ILocation generateRoom<T>(int number)
        {
            ILocation? room;
            switch (rnd.Next(1, 3))
            {
                case 1:
                    room = (ILocation)generateCombatRoom();
                    break;
                case 2:
                    room = (ILocation)generateOccuranceRoom();
                    break;
                default:
                    room = null;
                    break;
            }

            // The switch is closed, default will never be reached.
            // So we're not adding the nullable to the type and playing it dirty
            return room;
        }

        private static Combat generateCombatRoom()
        {
            int enemies = rnd.Next(1, 5);
            int idx = rnd.Next(0, COMBAT_NAMES.Length);
            Combat room = new Combat(COMBAT_NAMES[idx], enemies);
            for (int i = 0; i < enemies; i++)
            {
                room.AddContent(generateMob());
            }
            return room;
        }

        private static Mob generateMob()
        {
            int index = rnd.Next(0, MOB_NAMES.Length);
            Mob mob = new Mob(MOB_NAMES[index], rnd.Next(1, 50), rnd.Next(1, 10));

            int items = rnd.Next(1, 3);
            for (int i = 0; i < items; i++)
            {
                mob.AddItem(generateItem());
            }

            return mob;
        }

        private static Occurance generateOccuranceRoom()
        {
            int items = rnd.Next(1, 3);
            int idx = rnd.Next(0, OCCURANCE_NAMES.Length);
            Occurance room = new Occurance(OCCURANCE_NAMES[idx]);
            for (int i = 0; i < items; i++)
            {
                room.AddContent(generateItem());
            }
            return room;
        }

        private static Item generateItem()
        {
            int r = rnd.Next(1, 5);
            // Lady of code forgive me
            Stat? stat =
                r == 1
                    ? Stat.Damage
                    : r == 2
                        ? Stat.Health
                            : null;

            int modifier = rnd.Next(-10, 20);
            int idx = rnd.Next(0, ITEM_NAMES.Length);
            return new Item(ITEM_NAMES[idx], modifier, stat);
        }
    }
}
