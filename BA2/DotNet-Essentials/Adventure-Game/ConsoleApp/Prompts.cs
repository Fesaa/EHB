using World.Rooms;
using World.Content;

namespace ConsoleApp
{
    public class Prompts
    {

        public static Action PromptForAction(List<Action> exclude)
        {
            string s = "What would you like to do?";
            string error = "That is not a valid action. Please try again.";
            Dictionary<string, Action> dict = new Dictionary<string, Action>();

            foreach (Action action in Enum.GetValues(typeof(Action)))
            {
                if (!exclude.Contains(action))
                {
                    string input = action.ToString().ToLower().Substring(0, 1);
                    s += "\n" + input + ": " + action.ToString();
                    dict.Add(input, action);
                }
            }

            return WaitAndValidateInput(s, dict, error, 3);
        }

        public static Item PromptForItem(List<Item> items)
        {
            string s = "Which item would you like to take?";
            string error = "That is not a valid item. Please try again.";
            Dictionary<string, Item> dict = new Dictionary<string, Item>();
            for (int i = 0; i < items.Count; i++)
            {
                s += "\n" + i + ": " + items[i].Name;
                dict.Add("" + i, items[i]);
            }

            return WaitAndValidateInput(s, dict, error, 3);
        }

        public static IEntity PromptForAttact(List<IEntity> enemies)
        {
            string s = "Which enemy would you like to attack?";
            string error = "That is not a valid enemy. Please try again.";
            Dictionary<string, IEntity> dict = new Dictionary<string, IEntity>();
            for (int i = 0; i < enemies.Count; i++)
            {
                s += "\n" + i + ": " + enemies[i].Name;
                dict.Add("" + i, enemies[i]);
            }

            return WaitAndValidateInput(s, dict, error, 3);
        }

        public static Direction PromptForDirection()
        {
            string s = "Which direction would you like to go? (N, S, E, W)";
            string error = "That is not a valid direction. Please try again.";
            Dictionary<string, Direction> dict = new Dictionary<string, Direction>()
            {
                {"N", Direction.North },
                {"S", Direction.South },
                {"E", Direction.East },
                {"W", Direction.West }
            };

            return WaitAndValidateInput(s, dict, error, 3);
        }


        private static T WaitAndValidateInput<T>(string s, Dictionary<string, T> dict, string error, int tries)
        {
            if (tries == 0)
            {
                Console.WriteLine("You have no more tries left. Exiting...");
                Environment.Exit(0);
            }

            Console.WriteLine(s);

            string? input = Console.ReadLine();
            if (input == null)
            {
                Console.WriteLine("Input was null... try again");
                return WaitAndValidateInput(s, dict, error, tries - 1);
            }

            if (dict.ContainsKey(input))
            {
                return dict[input];
            }
            else
            {
                Console.WriteLine(error);
                return WaitAndValidateInput(s, dict, error, tries - 1);
            }




        }
    }

    public enum Action
    {
        Attack,
        Move,
        Take,
        Quit,
    }

}
