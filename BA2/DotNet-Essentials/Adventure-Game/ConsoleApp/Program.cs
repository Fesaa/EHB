using World;
using World.Rooms;
using World.Content;

namespace ConsoleApp
{
    public class ConsoleApp
    {

        public static bool PLAYING = true;

        public static Random rnd = new Random();

        public static void Main(string[] args)
        {
            Console.WriteLine("Welcome to the adventure game, what is your name?");
            string? name = Console.ReadLine();
            if (name == null)
            {
                Console.WriteLine("Don't be shy, give your name!");
                return;
            }

            Console.WriteLine("How many rooms do you want to be able to explore?");
            string? count = Console.ReadLine();
            if (count == null)
            {
                Console.WriteLine("Don't be shy, give a number!");
                return;
            }

            int c = 0;
            try
            {
                c = Int32.Parse(count);
            }
            catch (FormatException)
            {
                Console.WriteLine("That wasn't a number >:(");
                return;
            }

            World.World world = new World.World(name, c);

            Console.WriteLine("Welcome to the world, " + name + "!");

            while (PLAYING && world.rooms.Count > 0)
            {
                playerActionRoom(world, world.currentRoom);
                Console.Write("...");
                Console.ReadLine();
            }

            if (world.rooms.Count == 0)
            {
                Console.WriteLine("You have explored all the rooms! You win!");
            }
        }

        private static void playerActionRoom(World.World world, ILocation room)
        {
            Console.Write("\n\nYou are in " + room.Name + ". " + "\n" + playerInfoText(world.player) + "\n");

            if (room is Combat combat)
            {
                playerActionCombat(world, combat);
            }
            else if (room is Occurance occurance)
            {
                playerActionOccurance(world, occurance);
            }
        }

        private static void playerActionOccurance(World.World world, Occurance occurance)
        {

            if (occurance.Items.Count > 0)
            {
                Console.Write("You see: ");
                foreach (Item item in occurance.Items)
                {
                    Console.Write(item.Name + ", ");
                }
                Console.Write("\n");
            }
            else
            {
                Console.WriteLine("You have picked up all the items in this room.");
                doMove(world, occurance);
                return;
            }

            if (!occurance.CanAdvance())
            {
                Console.WriteLine("You still have to pick up items before you can leave. An item can have possitive, negative effects, or do nothing! Choose wisely.");
            }
            else
            {
                Console.WriteLine("You can leave this room now.");
            }
            doAction(world, occurance);
        }

        private static void playerActionCombat(World.World world, Combat combat)
        {

            if (combat.Enemies.Count > 0)
            {
                Console.Write("You see: ");
                Console.WriteLine(String.Join(", ", combat.Enemies.Select(e => e.Name)));
            }
            else
            {
                Console.WriteLine("You have killed all the enemies in this room.");
                doMove(world, combat);
                return;
            }

            if (!combat.CanAdvance())
            {
                Console.WriteLine("You still have to kill enemies before you can leave.");
            }
            else
            {
                Console.WriteLine("You can leave this room now.");
            }
            doAction(world, combat);
        }

        private static void doAction(World.World world, ILocation room)
        {

            Console.Write("\n\n");
            Action action = Prompts.PromptForAction(getExclusionList(room));
            switch (action)
            {
                case Action.Attack:
                    doAttack(world, (Combat)room);
                    break;
                case Action.Move:
                    doMove(world, room);
                    break;
                case Action.Take:
                    doTake(world, (Occurance)room);
                    break;
                case Action.Quit:
                    doQuit();
                    break;
            }
        }

        private static void doTake(World.World world, Occurance occurance)
        {
            Item item = Prompts.PromptForItem(occurance.Items);
            occurance.RemoveContent(item);
            world.player.AddItem(item);
            pickUpText(item);
        }

        private static void doQuit()
        {
            Console.WriteLine("Thanks for playing!");
            PLAYING = false;
        }

        // We can assume the player can always move as the Move action is filtered out before this method is called
        private static void doMove(World.World world, ILocation room)
        {
            if (room is Combat combat)
            {
                if (combat.Enemies.Count == 0)
                {
                    Console.WriteLine("This room will be destroyed after you leave. You cannot come back.");
                    world.rooms.Remove(room.Id);
                }
            }
            else if (room is Occurance occurance)
            {
                if (occurance.Items.Count == 0)
                {
                    Console.WriteLine("This room will be destroyed after you leave. You cannot come back.");
                    world.rooms.Remove(room.Id);
                }
            }

            if (world.rooms.Count == 0)
            {
                return;
            }

            Direction direction = Prompts.PromptForDirection();
            int? nextRoom = room.Compass.GetLocation(direction);
            if (nextRoom == null)
            {
                Console.WriteLine("You cannot go that way.");
                return;
            }

            if (!world.rooms.ContainsKey((int)nextRoom))
            {
                Console.WriteLine("This room was already destoyed, you're being sent to a random room.");
                nextRoom = world.rooms.Keys.ElementAt(rnd.Next(0, world.rooms.Count));
            }
            world.currentRoom = world.rooms[(int)nextRoom];
        }

        private static void doAttack(World.World world, Combat combat)
        {
            IEntity attacked = Prompts.PromptForAttact(combat.Enemies);

            // KeyValuePair<isDead, droppedItems>
            var playerResult = world.player.Attack(attacked);
            if (playerResult.Key)
            {
                Console.WriteLine("You have killed " + attacked.Name + "!");
                if (playerResult.Value != null)
                {
                    foreach (Item item in playerResult.Value)
                    {
                        pickUpText(item);
                    }
                }
                combat.RemoveContent(attacked);
                return;
            }
            else
            {
                Console.WriteLine("You have attacked " + attacked.Name + " for " + world.player.Damage + " damage.");
                Console.WriteLine("They have " + attacked.Health + " health left.");
            }

            var enemyResult = attacked.Attack(world.player);
            if (enemyResult.Key)
            {
                Console.WriteLine("You have been killed by " + attacked.Name + ". Game over.");
                Environment.Exit(0);
            }
            else
            {
                Console.WriteLine(attacked.Name + " has attacked you for " + attacked.Damage + " damage.");
                Console.WriteLine("You have " + world.player.Health + " health left.");
            }
        }

        private static void pickUpText(Item item)
        {
            Console.WriteLine("You have picked up " + item.Name + ".");
            if (item.Stat != null)
            {
                string s = item.Modifier > 0 ? "increased" : "decreased";
                switch (item.Stat)
                {
                    case Stat.Health:
                        Console.WriteLine("Your health has " + s + " by " + item.Modifier + ".");
                        break;
                    case Stat.Damage:
                        Console.WriteLine("Your damage has " + s + " by " + item.Modifier + ".");
                        break;
                }
            }
            else
            {
                Console.WriteLine("The item did nothing.");
            }
        }

        private static string playerInfoText(Player player)
        {
            return "You have " + player.Health + " health and " + player.Damage + " damage.";
        }

        private static List<Action> getExclusionList(ILocation room)
        {
            List<Action> exclude = new List<Action>();
            if (!room.CanAdvance())
            {
                exclude.Add(Action.Move);
            }

            if (!(room is Combat))
            {
                exclude.Add(Action.Attack);
            }
            if ((room is Combat combat) && combat.Enemies.Count == 0)
            {
                exclude.Add(Action.Attack);
            }

            if (!(room is Occurance))
            {
                exclude.Add(Action.Take);
            }
            if ((room is Occurance occurance) && occurance.Items.Count == 0)
            {
                exclude.Add(Action.Take);
            }
            return exclude;
        }
    }

}
