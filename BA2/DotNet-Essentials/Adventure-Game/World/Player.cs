using World.Content;

namespace World
{
    public class Player : IEntity
    {
        public int Id { get; }

        public string Name { get; }

        public int Health { get; private set; }

        public int Damage { get; private set; }

        public IEnumerable<Item> Inventory { get; }

        public Player(string name)
        {
            Id = IdGenerator.GetId();
            Name = name;
            Health = 100;
            Damage = 10;
            Inventory = new List<Item>();
        }

        public void AddItem(Item item)
        {
            ((List<Item>)Inventory).Add(item);
            if (item.Stat != null)
            {
                switch (item.Stat)
                {
                    case Stat.Health:
                        Health += item.Modifier;
                        break;
                    case Stat.Damage:
                        Damage += item.Modifier;
                        break;
                }
            }

        }

        public KeyValuePair<bool, IEnumerable<Item>?> Attack(IEntity entity)
        {
            bool isDead = entity.TakeDamage(Damage);
            if (isDead)
            {
                IEnumerable<Item> items = entity.Inventory;
                for (int i = 0; i < items.Count(); i++)
                {
                    AddItem(items.ElementAt(i));
                }
                return new KeyValuePair<bool, IEnumerable<Item>?>(true, items);
            }
            return new KeyValuePair<bool, IEnumerable<Item>?>(isDead, null);
        }

        public bool TakeDamage(int damage)
        {
            Health -= damage;
            return Health <= 0;
        }

        public bool IsDead()
        {
            return Health <= 0;
        }
    }

}
