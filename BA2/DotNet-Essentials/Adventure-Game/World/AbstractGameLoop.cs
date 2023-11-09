using World.Content;
using World.Rooms;

namespace World
{
    public abstract class AbstractGameLoop
    {
        protected bool running = false;
        protected Random rnd = new Random();
        protected World world;

        private Action lastAction = Action.Move;
        /// <summary>
        /// Ran on each room enter
        /// </summary>
        /// <param name="room">The current room</param>
        abstract protected void OnRoomEnter(ILocation room);
        /// Ran if an action will take place
        abstract protected void OnRoomInfo(ILocation room);
        /// Ran if the player is forced to advance
        abstract protected void OnForceAdvance(ILocation room);
        /// Ran if the player can advance, but doesn't have to
        abstract protected void OnPossibleAdvance(ILocation room);
        /// Ran if the player can't advance yet
        abstract protected void OnStuck(ILocation room);

        /// Ran before the player chooses an action
        abstract protected void OnActionStart(ILocation room);
        /// Filter possible actions and return the chosen one
        abstract protected Action GetActionInput(List<Action> actions);
        /// Ran after the player chooses an action
        abstract protected void OnAction(Action action, ILocation room);

        /// Filter possible items and return the chosen one
        abstract protected Item GetItemInput(List<Item> items);
        /// Ran after the player picks up an item
        abstract protected void OnItemPickup(Item item);

        abstract protected IEntity GetEnemyInput(List<IEntity> enemies);
        /// Ran after the player kills an enemy
        abstract protected void OnEnemyKill(IEntity enemy);
        /// Ran after the player damages an enemy
        abstract protected void OnEnemyDamage(IEntity enemy, int damage);
        /// Ran after the player is damaged by an enemy
        abstract protected void OnEnemyAttack(IEntity enemy, int damage);

        /// Ran after the player destroys a room
        abstract protected void OnRoomDestruction(ILocation room);
        /// Ran for invalid direction
        abstract protected void OnInvalidDirection();
        /// Ran after the player is send a random room
        abstract protected void OnRandomRoom();
        /// Return direction input
        abstract protected Direction GetDirectionInput();

        /// Ran after the player wins
        abstract protected void WinMessage();
        /// Ran after the player loses
        abstract protected void LoseMessage();
        /// Ran after the player quits
        abstract protected void QuitMessage();

        /// Ran before each tick
        /// The first last action is almost Action.Movr
        abstract protected void OnPreTick(Action lastAction);
        /// Ran after each tick
        abstract protected void OnPostTick(Action currentAction);

        public AbstractGameLoop(string playerName) : this(playerName, 10) { }

        public AbstractGameLoop(string playerName, int count)
        {
            world = new World(playerName, count);
        }

        public void Run()
        {
            running = true;

            while (running && !world.isCompleted())
            {
                OnPreTick(lastAction);
                enterRoom(world.currentRoom);
                OnPostTick(lastAction);
            }
        }

        private void enterRoom(ILocation room)
        {
            OnRoomEnter(room);

            if (room.HasToAdvance())
            {
                OnForceAdvance(room);
                doMove(room);
                return;
            }

            OnRoomInfo(room);

            if (room.CanAdvance())
            {
                OnPossibleAdvance(room);
            }
            else
            {
                OnStuck(room);
            }

            doAction(room);
        }

        private void doAction(ILocation room)
        {
            OnActionStart(room);

            Action action = GetActionInput(room.GetActions());
            lastAction = action;
            switch (action)
            {
                case Action.Attack:
                    doAttack((Combat)room);
                    break;
                case Action.Move:
                    doMove(room);
                    break;
                case Action.Take:
                    doTake((Occurance)room);
                    break;
                case Action.Quit:
                    doQuit();
                    break;
            }
        }

        private void doAttack(Combat combat)
        {
            IEntity enemy = GetEnemyInput(combat.Enemies);

            // <isDead, droppedItems>
            KeyValuePair<bool, IEnumerable<Item>?> result = world.player.Attack(enemy);

            if (result.Key)
            {
                OnEnemyKill(enemy);
                if (result.Value != null)
                {
                    foreach (Item item in result.Value)
                    {
                        world.player.AddItem(item);
                        OnItemPickup(item);
                    }
                }
                combat.RemoveContent(enemy);
                return;
            }
            else
            {
                OnEnemyDamage(enemy, world.player.Damage);
            }

            KeyValuePair<bool, IEnumerable<Item>?> enemyResult = enemy.Attack(world.player);
            if (enemyResult.Key)
            {
                QuitMessage();
                running = false;
                return;
            }

            OnEnemyAttack(enemy, enemy.Damage);

        }

        private void doMove(ILocation room)
        {
            if (room.HasToAdvance())
            {
                OnRoomDestruction(room);
                world.rooms.Remove(room.Id);
            }

            if (world.rooms.Count == 0)
            {
                WinMessage();
                running = false;
                return;
            }

            Direction direction = GetDirectionInput();
            int? nextRoom = room.Compass.GetLocation(direction);
            if (nextRoom == null)
            {
                OnInvalidDirection();
                return;
            }

            if (!world.rooms.ContainsKey((int)nextRoom))
            {
                OnRandomRoom();
                nextRoom = world.rooms.Keys.ElementAt(rnd.Next(0, world.rooms.Count));
            }
            world.currentRoom = world.rooms[(int)nextRoom];
        }

        private void doTake(Occurance occurance)
        {
            Item item = GetItemInput(occurance.Items);
            occurance.RemoveContent(item);
            world.player.AddItem(item);
            OnItemPickup(item);
        }

        private void doQuit()
        {
            running = false;
            QuitMessage();
        }

        public Player GetPlayer()
        {
            return world.player;
        }

        public World GetWorld()
        {
            return world;
        }


    }

    public enum Action
    {
        Attack,
        Move,
        Take,
        Quit,
    }
}
