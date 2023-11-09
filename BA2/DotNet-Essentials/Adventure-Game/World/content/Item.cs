namespace World.Content
{
    public class Item : IContent
    {

        public string Name { get; private set; }
        public int Id { get; private set; }
        public int Modifier { get; private set; }
        public Stat? Stat { get; private set; }

        public Item(string name, int modifier, Stat? stat = null)
        {
            Id = IdGenerator.GetId();
            Name = name;
            Modifier = modifier;
            Stat = stat;
        }
    }

    public enum Stat
    {
        Health,
        Damage
    }
}
