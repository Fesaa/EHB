namespace World.Rooms
{
    public class Compass
    {
        private Dictionary<Direction, int> locations;

        public Compass()
        {
            locations = new Dictionary<Direction, int>();
        }

        public void AddLocation(Direction direction, int locationID)
        {
            locations.Add(direction, locationID);
        }

        /// <summary>
        /// Get the location in a certain paramref name="direction"
        /// </summary>
        /// <param name="direction">paramref name="direction"</param>
        /// <returns>Nullable location T</returns>
        public int? GetLocation(Direction direction)
        {
            if (locations.ContainsKey(direction))
            {
                return locations[direction];
            }
            return null;
        }

        public int Count
        {
            get => locations.Count;
        }
    }

    public enum Direction
    {
        North,
        South,
        East,
        West
    }
}
