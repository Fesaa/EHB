using World.Content;

namespace World.Rooms
{
    public class Occurance : ILocation
    {
        public int Id { get; private set; }

        public string Name { get; private set; }

        public List<Item> Items { get; private set; }

        private int counter = 0;

        public Compass Compass { get; private set; }

        public Occurance(string name)
        {
            Id = IdGenerator.GetId();
            Name = name;
            Items = new List<Item>();
            Compass = new Compass();
        }

        public void AddContent(Item content)
        {
            Items.Add(content);
            counter++;
        }

        public void RemoveContent(Item content)
        {
            Items.Remove(content);
        }

        public bool CanAdvance()
        {
            return Items.Count < counter;
        }

        public bool HasToAdvance()
        {
            return Items.Count == 0;
        }

        public List<Action> GetActions()
        {
            List<Action> actions = new List<Action>() { Action.Quit };
            if (Items.Count > 0)
            {
                actions.Add(Action.Take);
            }
            if (CanAdvance())
            {
                actions.Add(Action.Move);
            }
            return actions;
        }
    }
}
