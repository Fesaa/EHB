namespace World.Rooms
{
    public interface ILocation
    {
        public int Id { get; }
        public string Name { get; }

        public Compass Compass { get; }

        public bool CanAdvance();
    }
}
