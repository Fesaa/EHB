using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;

namespace World
{
    public class Player : IEntity
    {
        private static readonly double START_HEALTH = 100;
        private static readonly double START_ATTACK = 10;
        private static readonly double START_DEFENSE = 10;

        private string name;
        private double health;
        private double attack;
        private double defense;

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
            this.defense = START_DEFENSE;
            this.inventory.AddRange(inventory);
        }

        public void die()
        {
            Console.WriteLine("You died!");
            Environment.Exit(0);
        }

        public double GetAttack()
        {
            return attack;
        }

        public double GetDefense()
        {
            return defense;
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

        public void SetDefense(double defense)
        {
            this.defense = defense;
        }

        public void SetHealth(double health)
        {
            this.health = health;
        }

        public bool TakeDamage(IEntity attacker)
        {
            double damage = attacker.GetAttack();
            damage -= defense / 2;

            if (damage < 0)
            {
                return false;
            }

            health -= damage;

            if (health <= 0)
            {
                die();
            }

            return true;
        }
    }
}
