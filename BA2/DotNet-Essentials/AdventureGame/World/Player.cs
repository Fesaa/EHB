using System.Collections.Generic;
using System.Collections.ObjectModel;

namespace World
{
    public class Player : IEntity
    {
        private static readonly double START_HEALTH = 100;
        private static readonly double START_ATTACK = 10;

        private string name;
        private double health;
        private double attack;

        private List<Item> inventory;

        public Player(string name)
            : this(name, new Collection<Item>())
        {
        }

        public Player(string name, Collection<Item> inventory)
        {
            this.name = name;
            this.health = START_HEALTH;
            this.attack = START_ATTACK;
            this.inventory.AddRange(inventory);
        }

        public void addItem(Item item)
        {
            inventory.Add(item);
        }

        public double GetAttack()
        {
            return attack;
        }

        public double GetHealth()
        {
            return health;
        }

        public string GetName()
        {
            return name;
        }

        public void SetAttack(double attack)
        {
            this.attack = attack;
        }

        public void SetHealth(double health)
        {
            this.health = health;
        }

        ///
        /// <summary>
        /// Returns true if the player died.
        public bool TakeDamage(IEntity attacker)
        {
            double damage = attacker.GetAttack();
            if (damage < 0)
            {
                return false;
            }

            health -= damage;
            return health <= 0;
        }
    }
}
