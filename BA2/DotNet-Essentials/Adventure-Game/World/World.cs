using World.Rooms;

namespace World
{
    public class World
    {

        public Dictionary<int, ILocation> rooms { get; private set; }
        public ILocation currentRoom { get; set; }

        public Player player { get; private set; }

        public World(string playerName) : this(playerName, 10) { }

        public World(string playerName, int count)
        {
            player = new Player(playerName);
            rooms = new Dictionary<int, ILocation>();

            var roomsList = RoomGenerator.GenerateRooms(count);

            Random rnd = new Random();
            int l = roomsList.Count;

            // Connect rooms randomly
            foreach (ILocation room in roomsList)
            {
                rooms[room.Id] = room;
                foreach (Direction dir in Enum.GetValues(typeof(Direction)))
                {
                    int idx = rnd.Next(l);
                    room.Compass.AddLocation(dir, roomsList[idx].Id);
                }
            }

            currentRoom = roomsList.First();
        }

        public bool isCompleted()
        {
            return rooms.Count == 0;
        }
    }
}
