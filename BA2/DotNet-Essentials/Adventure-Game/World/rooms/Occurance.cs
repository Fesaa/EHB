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
    }
}
