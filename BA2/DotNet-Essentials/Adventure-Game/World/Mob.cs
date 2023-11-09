using World.Content;

namespace World
{
    public class Mob : IEntity
    {
        public int Id { get; }

        public string Name { get; }

        public int Health { get; private set; }

        public int Damage { get; }

        public IEnumerable<Item> Inventory { get; }

        public Mob(string name, int health, int damage)
        {
            Id = IdGenerator.GetId();
            Name = name;
            Health = health;
            Damage = damage;
            Inventory = new List<Item>();
        }

        public void AddItem(Item item)
        {
            ((List<Item>)Inventory).Add(item);
        }

        public KeyValuePair<bool, IEnumerable<Item>?> Attack(IEntity entity)
        {
            bool isDead = entity.TakeDamage(Damage);
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
