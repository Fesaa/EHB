using System.Collections.Generic;

namespace World
{
    public interface ILocation
    {

        ILocation previous();

        List<ILocation> next();

        List<Item> items();


    }
}
