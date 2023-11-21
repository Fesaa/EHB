using System.Collections.Generic;

namespace World
{

    public interface ILocation
    {

        /// <summary>
        /// The previous location in the game world.
        /// </summary>
        /// <returns> ILocation - nullable </returns>
        ILocation previous();

        ICollection<ILocation> next();

        ICollection<Item> items();

        ICollection<IEntity> entities();

        string enterText();

        string exitText();

    }
}
