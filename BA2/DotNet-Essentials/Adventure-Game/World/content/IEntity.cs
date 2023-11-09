namespace World.Content
{
    public interface IEntity : IContent
    {
        public int Health { get; }
        public int Damage { get; }

        public IEnumerable<Item> Inventory { get; }
        public void AddItem(Item item);

        /// <summary>
        /// Attacks the entity.
        /// </summary>
        /// <param name="entity">The entity to attack</param>
        /// <returns>Wether the paramref name="entity" has died. And the consumed items</returns>
        public KeyValuePair<bool, IEnumerable<Item>?> Attack(IEntity entity);

        /// <summary>
        /// Deals damage to the entity.
        /// </summary>
        /// <param name="damage">Amount of damage</param>
        /// <returns>Wether the enitity died</returns>
        public bool TakeDamage(int damage);

        public bool IsDead();
    }
}
