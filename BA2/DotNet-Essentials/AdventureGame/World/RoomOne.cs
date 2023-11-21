using System.Collections.Generic;

namespace World
{
    public class RoomOne : ILocation
    {

        public RoomOne(ICollection<ILocation> next)
        {
            _entities = new List<IEntity>();
            _items = new List<Item>();
            _next = next;
        }

        private List<IEntity> _entities;
        private List<Item> _items;
        private ICollection<ILocation> _next;

        public string enterText()
        {
            return "You have entered the first room. Welcome!";
        }

        public ICollection<IEntity> entities()
        {
            return _entities;
        }

        public string exitText()
        {
            return "Congratulations! You have exited the first room, and survived!";
        }

        public ICollection<Item> items()
        {
            return _items;
        }

        public ICollection<ILocation> next()
        {
            return _next;
        }

        public ILocation previous()
        {
            return null;
        }
    }
}
