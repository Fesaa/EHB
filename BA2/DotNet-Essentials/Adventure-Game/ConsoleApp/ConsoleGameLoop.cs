using World;
using World.Content;
using World.Rooms;

namespace ConsoleApp
{
    public class ConsoleGameLoop : World.AbstractGameLoop
    {
        public ConsoleGameLoop(string playerName, int roomCount) : base(playerName, roomCount)
        {
        }

        protected override void OnPreTick(World.Action action)
        {
            if (action == World.Action.Move)
            {
                return;
            }

            Console.WriteLine("...");
            Console.ReadLine();
        }

        protected override void OnPostTick(World.Action action)
        {
        }

        protected override World.Action GetActionInput(List<World.Action> actions)
        {
            return Prompts.PromptForAction(actions);
        }

        protected override Direction GetDirectionInput()
        {
            return Prompts.PromptForDirection();
        }

        protected override IEntity GetEnemyInput(List<IEntity> enemies)
        {
            return Prompts.PromptForAttact(enemies);
        }

        protected override Item GetItemInput(List<Item> items)
        {
            return Prompts.PromptForItem(items);
        }

        protected override void LoseMessage()
        {
            Console.WriteLine("You have died! Game over!");
        }

        protected override void OnAction(World.Action action, ILocation room)
        {
        }

        protected override void OnActionStart(ILocation room)
        {
            Console.WriteLine("\n\n");
        }

        protected override void OnEnemyAttack(IEntity enemy, int damage)
        {
            Console.Write(enemy.Name + " has attacked you for " + enemy.Damage + " damage.");
            Console.WriteLine(" You have " + this.GetPlayer().Health + " health left.");
        }

        protected override void OnEnemyDamage(IEntity enemy, int damage)
        {
            Console.Write("You have attacked " + enemy.Name + " for " + this.GetPlayer().Damage + " damage.");
            Console.WriteLine(" They have " + enemy.Health + " health left.");
        }

        protected override void OnEnemyKill(IEntity enemy)
        {
            Console.WriteLine("You have killed " + enemy.Name + "!");
        }

        protected override void OnForceAdvance(ILocation room)
        {
            if (room is Combat combat)
            {
                Console.WriteLine("You have killed all the enemies in this room.");
            }
            else if (room is Occurance occurance)
            {
                Console.WriteLine("You have picked up all the items in this room.");
            }
            else
            {
                Console.WriteLine("You have destroyed this room.");
            }
        }

        protected override void OnInvalidDirection()
        {
            Console.WriteLine("You cannot go that way.");
        }

        protected override void OnItemPickup(Item item)
        {
            Console.WriteLine("You have picked up " + item.Name + ".");
            if (item.Stat != null)
            {
                string s = item.Modifier > 0 ? "increased" : "decreased";
                switch (item.Stat)
                {
                    case Stat.Health:
                        Console.WriteLine("Your health has " + s + " by " + item.Modifier + ".");
                        break;
                    case Stat.Damage:
                        Console.WriteLine("Your damage has " + s + " by " + item.Modifier + ".");
                        break;
                }
            }
            else
            {
                Console.WriteLine("The item did nothing.");
            }
        }

        protected override void OnPossibleAdvance(ILocation room)
        {
            Console.WriteLine("You can leave this room now.");
        }

        protected override void OnRandomRoom()
        {
            Console.WriteLine("This room was already destoyed, you're being sent to a random room.");
        }

        protected override void OnRoomDestruction(ILocation room)
        {
            Console.WriteLine("This room will be destroyed after you leave. You cannot come back.");
        }

        protected override void OnRoomEnter(ILocation room)
        {
            Console.Write("\n\nYou are in " + room.Name + ". " + "\n" + playerInfoText(this.GetPlayer()) + "\n");
        }

        protected override void OnRoomInfo(ILocation room)
        {
            if (room is Combat combat)
            {
                Console.Write("You see: ");
                Console.WriteLine(String.Join("\n\t-", combat.Enemies.Select(e => e.Name)));
            }
            else if (room is Occurance occurance)
            {
                Console.Write("You see: ");
                Console.WriteLine(String.Join("\n\t-", occurance.Items.Select(e => e.Name)));
            }
            else
            {
                Console.WriteLine("You see nothing.");
            }
        }

        protected override void OnStuck(ILocation room)
        {
            if (room is Combat)
            {
                Console.WriteLine("You still have to kill enemies before you can leave.");
            }
            else if (room is Occurance)
            {
                Console.WriteLine("You still have to pick up items before you can leave. An item can have possitive, negative effects, or do nothing! Choose wisely.");
            }
            else
            {
                Console.WriteLine("You are stuck!");
            }
        }

        protected override void QuitMessage()
        {
            Console.WriteLine("Thanks for playing!");
        }

        protected override void WinMessage()
        {
            Console.WriteLine("You have explored all the rooms! You win!");
        }

        private string playerInfoText(Player player)
        {
            return "You have " + player.Health + " health and " + player.Damage + " damage.";
        }
    }
}
