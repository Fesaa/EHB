using System;
using System.Linq;
using System.Collections.Generic;
using System.Collections;

namespace Vector
{
    public class VectorImpl<T> : IEnumerable<T>
    {

        private T[] _items;

        private int count;

        public VectorImpl() : this(1) { }

        public VectorImpl(int initialCapacity)
        {
            _items = new T[initialCapacity];
            count = 0;
        }

        public void PushBack(T item)
        {
            if (_items.Length == count)
                Grow();
            _items[count++] = item;
        }

        public T PopBack()
        {
            if (count == 0)
            {
                return default(T);
            }
            return _items[--count];
        }

        public T GetItem(int index)
        {
            if (index < 0 || index >= count)
            {
                throw new IndexOutOfRangeException();
            }
            return _items[index];
        }

        public override String ToString()
        {
            return String.Join(" ", _items.Take(count));
        }

        private void Grow()
        {
            T[] newItems = new T[_items.Length * 2];
            Array.Copy(_items, newItems, _items.Length);
            _items = newItems;
        }

        public IEnumerator<T> GetEnumerator()
        {
            for (int i = 0; i < count; i++)
            {
                yield return _items[i];
            }
        }


        IEnumerator IEnumerable.GetEnumerator()
        {
            return GetEnumerator();
        }
    }
}
