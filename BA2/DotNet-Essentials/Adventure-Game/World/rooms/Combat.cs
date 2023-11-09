using World.Content;

namespace World.Rooms
{
    public class Combat : ILocation
    {
        public int Id { get; private set; }

        public string Name { get; private set; }

        public List<IEntity> Enemies { get; private set; }

        private int counter = 0;

        public Compass Compass { get; private set; }

        public Combat(string name, int enemiesCount)
        {
            Id = IdGenerator.GetId();
            Name = name;
            Enemies = new List<IEntity>(enemiesCount);
            Compass = new Compass();
        }

        public void AddContent(IEntity entity)
        {
            Enemies.Add(entity);
            counter++;
        }

        public void RemoveContent(IEntity entity)
        {
            Enemies.Remove(entity);
        }

        public bool CanAdvance()
        {
            return Enemies.Count < Compass.Count && Enemies.Count < counter;
        }
    }
}
